<?php
/**
 * 异常处理程序基类
 * Created by yinchuanan.
 * Author: yinchuanan
 * Date: 2017/10/11
 * Time: 17:42
 */

namespace app\common\lib\exception;
use think\Exception;
use Error\ErrorMsg;
class BaseException extends Exception
{
    // HTTP 状态码 404,200 等
    public $httpCode = 200;
    //错误具体信息
    public $message = '参数错误';
    //自定义的错误码
    public $status = '';

    /**
     * @param string $message
     * @param int $httpCode
     * @param int $code
     * 40000 为一般提示性错误
     * 00000 为关站错误
     */
    public function __construct($message,$httpCode = 200,$status = '') {
       
        if($status === 40000 || $status === 0){
            $this->httpCode = $httpCode;
            $this->status   = $status;
            $this->message  = $message;
            
        }else{
            $this->httpCode = $httpCode;
            $this->status   = $message;
            $this->message  = ErrorMsg::getErrMsg($message);
        }
    }
}