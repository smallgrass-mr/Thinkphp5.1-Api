<?php

/**.
 * 验证层基础类
 * Author: yzb
 */

namespace app\common\validate;

use app\common\lib\exception\ApiException;
use think\facade\Request;
use think\Validate;
use app\common\cache\NoSqlManage;

class BaseValidate extends Validate
{

    /**
     * 场景校验
     * @param $scene 场景值
     * @return mixed
     * @author yinchuanan
     */
    public function goCheck($scene)
    {
        //对参数做校验
        $params  = Request::param();
        if (!$this->scene($scene)->check($params)) {
            throw new ApiException($this->error,200, 40000);
        } else {
            return $params;
        }
    }

    /**
     * 验证是否一个正整数
     * @param $value
     * @author yinchuanan
     */
    protected function isPositiveInteger($value)
    {
        if (is_numeric($value) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 验证是否一个参数是否不为空
     * @param $value
     * @author yinchuanan
     */
    protected function isNotEmpty($value)
    {
        return empty($value) ? false : true;
    }

    /**
     * 验证是否数字加字母
     */
    protected function isNumberAlphabet($value)
    {
        if(!preg_match('/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9a-zA-Z]+$/', $value)) {
            return false;
        }
        return true;
    }

    /**
     * 获取交易密码验证模式
     */
    protected function checkTradePwd($value)
    {
        $token = Request::header('token');
        $cache = new NoSqlManage();
        $user_info = json_decode($cache->getLoginToken($token),true);
        $tpwdsetting =  empty($user_info['tpwdsetting']) ? '' :$user_info['tpwdsetting'];
        if($tpwdsetting == 2 && empty($value)){
            return false;
        }
        return true;
    }

    /**
     * 获取提币google验证模式
     */
    protected function checkCoinOutGoogle($value)
    {
        $token = Request::header('token');
        $cache = new NoSqlManage();
        $user_info = json_decode($cache->getLoginToken($token),true);
        if($user_info['google']['coin_out'] == 1 && !empty($value)){
            return true;
        }
        return false;
    }

    /**
     * 验证是否只能 数字和字母
     */
    protected function isNumberOrAlphabet($value)
    {
        if(!preg_match('/^[a-zA-Z]{1}[0-9a-zA-Z_]{5,15}$/',$value)){
            return false;
        }
        return true;
    }

    /**
     * 验证金额是否正确
     */
    protected function isMoney($value)
    {
        if(!preg_match('/(^[1-9](\d+)?(\.\d{1,2})?$)|(^(0){1}$)|(^\d\.\d{1,2}?$)/', $value)){
            return false;
        }
        return true;
    }


    /**
     * 市场值传递是否正确
     * @param $value
     * @return bool
     */
    protected function isMarket($value)
    {
        if (!preg_match('/^([a-z0-9])+_([a-z0-9])+$/', $value)) {
            return false;
        }
        return true;
    }


    protected function isNumeric($value)
    {
        if (!is_numeric($value)) {
            return false;
        }
        return true;
    }

    /**
     * 判断是否一个数组
     * @param $value
     * @return bool
     */
    protected function isArray($value)
    {
        if (!is_array($value)) {
            return false;
        }
        return true;
    }

}
