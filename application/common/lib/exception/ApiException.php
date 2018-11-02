<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/6
 * Time: 上午2:57
 */
namespace app\common\lib\exception;

class ApiException extends BaseException {
    //自定义的错误码
    public $status   = 40000;
    //错误具体信息
    public $message  = '参数错误';
    public $httpCode = 200;

}