<?php
namespace App\Repositories\SmsSendSetting;
use App\Models\Backend\SmsSendSetting;


class SmsSendSettingRepository implements SmsSendSettingInterface {

    public function all(){
        return SmsSendSetting::orderByDesc('id')->paginate(10);
    }

}
