<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Container;
use Error\ErrorMsg;

/**
 * 统一输出
 * @param $result
 * @param int $httpCode
 * @return \think\response\Json
 */
function show($result, $httpCode = 200)
{
    if ($result['status'] == 10000 || $result['status'] == 99000) {
        $result['message'] = empty($result['message']) ? '成功' : $result['message'];
    } else {
        $result['message'] = ErrorMsg::getErrMsg($result['status']);
    }
    return json($result, $httpCode);
}

/**
 * 随机生成验证码
 * @len 生成多少位验证码
 * @return string
 * @author yinchuanan
 */
function getCode($len)
{
    $chars = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    $charsLen = count($chars) - 1;
    shuffle($chars);
    $output = "";
    for ($i = 0; $i < $len; $i++) {
        $output .= $chars[mt_rand(0, $charsLen)];
    }
    return $output;
}

/**
 * 获取短信场景
 * @param string $type 场景
 * @return array
 * @author yinchuanan
 */
function getSmsType($type)
{
    $config = [
        //注册网站
        'reg' => [
            'Y_SMS_CONTENT' => '您正在进行 手机注册，您的验证码是%s',
            'SMS_CONTENT' => '您正在进行手机注册操作，您的验证码是%s',
        ],
        //短信登录
        'login' => [
            'Y_SMS_CONTENT' => '您正在进行登录操作，您的验证码是%s，五分钟有效，请勿告诉别人',
            'SMS_CONTENT' => '您正在进行手机登录操作，您的验证码是%s'
        ],
        //修改登录密码
        'reset_login_pwd' => [
            'Y_SMS_CONTENT' => '您正在进行修改 登录密码，您的验证码是%s',
            'SMS_CONTENT' => '您正在进行修改登录密码操作，您的验证码是%s',
        ],
        //找回登录密码
        'findpwd' => [
            'Y_SMS_CONTENT' => '您正在进行找回 登录密码，您的验证码是%s',
            'SMS_CONTENT' => '您正在进行找回登录密码操作，您的验证码是%s',
        ],
        //修改个人登陆密码
        'reset_resume_login_pwd' => [
            'Y_SMS_CONTENT' => '您正在进行修改 个人登录密码，您的验证码是%s',
            'SMS_CONTENT' => '您正在进行修改个人登录密码操作，您的验证码是%s',
        ],
    ];
    if (isset($config[$type]) && $config[$type]) {
        return $config[$type];
    }
    return false;
}

/**
 * get请求地址
 * @param string $url
 * @param int $httpCode 返回状态码
 * @return mixed
 */
function curlGet($url, &$httpCode = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //不做证书校验,部署在linux环境下请改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $file_contents = curl_exec($ch);
    $httpCode      = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}

/**
 * 获取指定长度串码
 * @param $length
 * @return null|string
 */
function getRandChar($length)
{
    $str    = '';
    $strPol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    $max    = strlen($strPol) - 1;

    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)];
    }
    return $str;
}