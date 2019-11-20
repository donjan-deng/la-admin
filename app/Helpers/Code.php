<?php

namespace App\Helpers;

use App\Model\Message;

class Code {

    const ERROR = 0;
    const SUCCESS = 200; //成功
    const VALIDATE_ERROR = 422; //验证错误
    const DISALLOW = 403;
    const RECORD_NOT_FOUND = 404;
    const SAVE_DATA_ERROR = 1001; //保存数据失败
    const UNAUTHENTICATED = 401; //未登录
    const QUERYEXCEPTION = 1002; //QueryException
    const TOKENMISMATCH = 1010; //crsf token 验证不通过 
    const INCORRECT_PASSWORD = 1003; //用户名或者密码错误
    const RECORD_RECEIVED = 1004; //资料已经被领取
    const PARAMS_ERROR = 1005; //参数错误
    const UNKNOWN_DEPARTMENT = 1006; //未知部门
    const USER_DISABLE = 1007; //用户已禁用
    const USER_NOT_FOUND = 1008; //用户不存在 
    const SMS_SEND_FAILED = 1009; //短信发送失败

    protected static $codes = null;

    public static function getCodes() {
        if (is_null(self::$codes)) {
            self::$codes = Message::where('type', '=', 1)->pluck('message', 'id');
        }
        return self::$codes;
    }

    public static function msg($code) {
        return self::getCodes()[$code];
    }

}
