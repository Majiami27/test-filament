<?php

namespace App\Service;

use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class IotService
{
    protected $user;

    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('app.iot_api_url', 'http://localhost');
    }

    /**
     * 發送給 /device
     *
     * @param ?? $user   傳入資料auth()->user()
     */
    public function postDevice(User $user)
    {
        if (! $user->hasAnyRole(['admin', 'super_admin'])) {
            return false;
        }

        $request = ['email' => $user->email];

        $response = Http::post("$this->apiUrl/device", $request);

        \Log::debug('=== call in postDevice ===');
        \Log::debug($response->json());

        if ($response->ok()) {
            $rsData = $response->json();

            // 有需要驗證設備, 打驗證api
            if (isset($rsData['adoptable'])) {
                foreach ($rsData['adoptable'] as $key => $row) {
                    $this->postDeviceAdopt($user, $row['mac_addr']);
                }
                // 自動驗證設備
                $rsData = Http::post("$this->apiUrl/device", $request)->json();

                \Log::debug('=== after adopt ===');
                \Log::debug($rsData);
            }

            // bind_code為null時寫入
            if (! isset($user->bind_code) && isset($rsData['bindCode'])) {
                $user->update(['bind_code' => $rsData['bindCode']]);
            }

            // 判斷設備是否存在
            $organizationDevices = Device::where('organization_id', $user->id)->get();

            foreach (data_get($rsData, 'devices', []) as $row) {
                if ($organizationDevices && $organizationDevices->where('mac_address', $row['mac_addr'])->first()) {
                    Device::updateOrCreate(['mac_address' => $row['mac_addr']],
                        [
                            'ip' => '001_ip',
                            'ssid' => '001_SSID',
                            'status' => $row['dev_online'],
                        ]);
                } else {
                    Device::create([
                        'organization_id' => $user->id,
                        'mac_address' => $row['mac_addr'],
                        'ip' => 'TEST_ip',
                        'ssid' => 'TEST_SSID',
                        'status' => $row['dev_online'],
                    ]);
                }
            }

            return true;
        }

        return false;

        // TODO:\Log::debug('after EditAction');

    }

    public function postDeviceAdopt(User $user, string $macAddr)
    {
        $request = [
            'email' => $user->email,
            'macAddr' => $macAddr,
        ];
        $response = Http::post("$this->apiUrl/device/adopt", $request);

        if ($response->ok()) {
            return true;
        } else {
            return false;
        }
    }
}
