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
     * 取得設備列表
     *
     * @param ?? $user   傳入資料auth()->user()
     */
    public function postDevice(User $user)
    {
        if (! $user->hasAnyRole(['admin', 'super_admin'])) {
            $user = User::find($user->organization_id);
        } else {
            $user = ($user->organization_id === null) ? $user : User::find($user->organization_id);
        }

        $request = ['email' => $user->email];

        $response = Http::post("$this->apiUrl/device", $request);

        \Log::debug('=== call in postDevice ===');
        \Log::debug($response->json());

        if ($response->ok()) {
            $rsData = $response->json();

            // 有需要驗證設備, 打驗證api
            if (isset($rsData['adoptable']) && count($rsData['adoptable']) > 0) {
                foreach ($rsData['adoptable'] as $key => $row) {
                    $this->postDeviceAdopt($user, $row['macAddr']);
                }
                // 自動驗證設備
                $rsData = Http::post("$this->apiUrl/device", $request)->json();

                \Log::debug('=== after adopt ===');
                \Log::debug($rsData);
            }

            // bind_code為null時寫入
            if (! isset($user->bind_code) && isset($rsData['bindCode'])) {
                \Log::debug('=== update bind_code ===');
                \Log::debug($rsData['bindCode']);
                $user->update(['bind_code' => $rsData['bindCode']]);
            }

            // 判斷設備是否存在
            $organizationDevices = Device::where('organization_id', $user->id)->get();

            foreach (data_get($rsData, 'devices', []) as $row) {
                \Log::debug('=== get devices ===');
                if ($organizationDevices && $organizationDevices->where('mac_address', $row['macAddr'])->first()) {
                    $device = Device::updateOrCreate(['mac_address' => $row['macAddr']],
                        [
                            'ip' => $row['devIp'] ?? '',
                            'ssid' => $row['devSsid'] ?? '',
                            'status' => $row['devOnline'],
                        ]);
                    \Log::debug('=== update device ===');
                    \Log::debug($device);

                    // if exist, update
                    if (isset($row['devType']) && isset($row['devStatus'])) {
                        foreach ($row['devStatus'] as $port => $status) {
                            $device->details()->updateOrCreate(
                                ['port' => $port],
                                [
                                    'port_name' => "Port $port",
                                    'status' => $status,
                                ]);
                        }
                    }

                } else {
                    $device = Device::updateOrCreate(['mac_address' => $row['macAddr']],
                        [
                            'organization_id' => $user->id,
                            'ip' => $row['devIp'] ?? '',
                            'ssid' => $row['devSsid'] ?? '',
                            'status' => $row['devOnline'],
                        ]);
                    \Log::debug('=== create device ===');
                    \Log::debug($device);
                    \Log::debug('=== row ===');
                    \Log::debug($row);

                    if (isset($row['devType'])) {
                        $portNumber = match ($row['devType']) {
                            'relay8' => 8,
                            default => 0,
                        };

                        \Log::debug('=== portNumber ===');
                        \Log::debug($portNumber);

                        if ($portNumber > 0) {
                            $ports = [];
                            for ($i = 1; $i <= $portNumber; $i++) {
                                $ports[] = [
                                    'device_id' => $device->id,
                                    'port' => $i,
                                    'port_name' => "Port $i",
                                    'status' => false,
                                ];
                            }

                            \Log::debug('=== ports ===');
                            \Log::debug($ports);
                            $device->details()->createMany($ports);
                        }
                    }
                }
            }

            return true;
        }

        return false;

        // TODO:\Log::debug('after EditAction');

    }

    /**
     * 配對設備
     */
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

    /**
     * 控制設備
     */
    public function postDeviceControl(User $user, string $macAddr, array $action)
    {
        if (! $user->hasAnyRole(['admin', 'super_admin'])) {
            $user = User::find($user->organization_id);
        } else {
            $user = ($user->organization_id === null) ? $user : User::find($user->organization_id);
        }
        $request = [
            'email' => $user->email,
            'macAddr' => $macAddr,
            'status' => $action,
        ];
        $response = Http::post("$this->apiUrl/device/control", $request);

        if ($response->ok()) {
            return true;
        } else {
            return false;
        }
    }
}
