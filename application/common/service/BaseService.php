<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/14
 * Time: 13:51
 */

namespace app\common\service;


class BaseService
{

    /**
     * 生成Token
     * @return string
     * @author yinchuanan
     */
    public static function generateToken($subjoin = 'baidu')
    {
        //选取32个字符组成随机字符串
        $randChar = getRandChar(32);
        //我们用3组这样的字符串用md5 加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //盐
        $tokenSalt = config('server.token_salt');
        return md5(md5($randChar . $timestamp . $tokenSalt) . $subjoin);
    }

}