<?php

namespace App\Service;

use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use stdClass;

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
        // $request = ['email' => $user->email];
        $request = ['email' => 'tester@gmail.com'];

        $response = Http::post('https://iot.yomin.ddns.ms/device', $request);

        if ($response->ok()) {
            $rsData = $response->json();

            //region 測試假資料
            $fakeData = [
                ['dev_type' => 'asd', 'mac_addr' => '5CCF7FCB0023'],
                // ['dev_type' => 'asd', 'mac_addr' => 'CB00235CCF7F'],
            ];
            $rsData['adoptable'] = $fakeData;
            //endregion

            // 有需要認證設備, 打認證api (認證完後才會有devices資料, 那時再存入DB?)
            if ($rsData['adoptable']) {
                foreach ($rsData['adoptable'] as $key => $row) {
                    $this->postDeviceAdopt($user, $row['mac_addr']);
                }
            }

            // bind_code為null時寫入
            if (! isset($user->bind_code)) {
                $user->update(['bind_code' => $rsData['bindCode']]);
            }

            // 判斷設備是否存在
            if ($rsData['devices']) {
                foreach ($rsData['devices'] as $key => $row) {
                    $dbDeviceInfo = Device::where('mac_address', $row['mac_addr'])->first();
                    if (! is_array($dbDeviceInfo)) {
                        Device::create([
                            'mac_address' => $row['mac_addr'],
                            'name' => $row['id'],
                            'custom_id' => $row['account_id'],
                            'ip' => 'TEST_ip',
                            'ssid' => 'TEST_SSID',
                            'status' => $row['dev_online'],
                        ]);
                    }
                }
            }
        }

        // 回應
        $objJson = new stdClass;
        $objJson->Code = 200;
        $objJson->Msg = 'Success';

        return $objJson;
    }

    public function postDeviceAdopt($user, $macAddr)
    {
        $request = [
            // 'email' => $user->email,
            'email' => 'tester@gmail.com',
            'macAddr' => $macAddr,
        ];
        $response = Http::post('https://iot.yomin.ddns.ms/device/adopt', $request);

        if ($response->ok()) {
            // TODO: 確認認證成功需再打一次/Device將資料存回db
        }
    }
}
