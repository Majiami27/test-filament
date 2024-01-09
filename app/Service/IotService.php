<?php

namespace App\Service;

use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class IotService
{
    protected $user;

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

        $response = Http::post('https://iot.yomin.ddns.ms/device', $request);

        if ($response->ok()) {
            $rsData = $response->json();

            // 有需要驗證設備, 打驗證api
            if ($rsData['adoptable']) {
                foreach ($rsData['adoptable'] as $key => $row) {
                    $this->postDeviceAdopt($user, $row['mac_addr']);
                }
                // 自動驗證設備
                $rsData = Http::post('https://iot.yomin.ddns.ms/device', $request)->json();
            }

            // bind_code為null時寫入
            if (! isset($user->bind_code)) {
                $user->update(['bind_code' => $rsData['bindCode']]);
            }

            // 判斷設備是否存在
            $organizationDevices = Device::where('organization_id', $user->id)->get();

            foreach ($rsData['devices'] as $row) {
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
        } else {
            return false;
        }

        // TODO:\Log::debug('after EditAction');

    }

    public function postDeviceAdopt(User $user, string $macAddr)
    {
        $request = [
            'email' => $user->email,
            'macAddr' => $macAddr,
        ];
        $response = Http::post('https://iot.yomin.ddns.ms/device/adopt', $request);

        if ($response->ok()) {
            return true;
        } else {
            return false;
        }
    }
}
