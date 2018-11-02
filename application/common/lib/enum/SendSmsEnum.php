<?php
// +----------------------------------------------------------------------
// | Class Name  [ 短信场景类型枚举 ]
// +----------------------------------------------------------------------
// | Author yzb
// +----------------------------------------------------------------------

namespace app\common\lib\enum;


class SendSmsEnum {
    //登录
    const LOGIN        = 'login';
    //注册短信
    const REGISTER     = 'reg';
    //异地校验短信验证码
    const REMOTE       = 'remote';
    //找回密码短信
    const RETRIEVE_PWD = 'findpwd';
    //修改交易密码
    const REST_PAY_PWD = 'reset_pay_pwd';
    //找回交易密码
    const FIND_PAY_PWD  = 'findpwd_pay';
    //修改登录密码
    const REST_LOGIN_PWD = 'reset_login_pwd';
}