<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/6
 * Time: 上午2:45
 */

namespace app\common\lib\exception;


use Exception;
use think\exception\Handle;
use think\facade\Env;
use think\facade\Log;

class ApiHandleException extends Handle
{

    /**
     * http 状态码
     * @var int
     */
    // HTTP 状态码 404,200 等
    private $httpCode;
    //错误具体信息
    private $message;
    //自定义的错误码
    private $status;


    /**
     * 所有的异常都会用过render来渲染
     * @param Exception $e
     * @author yinchuanan
     */
    public function render(\Exception $e)
    {

        if ($e instanceof ApiException) {
            $this->httpCode = $e->httpCode;
            $this->message = $e->message;
            $this->status = $e->status;
            $this->recordErrorLog($e);
        } else {
            if (config('app_debug') == true) {
                return parent::render($e);
            }
            //服务端异常
            $this->httpCode = 500;
            $this->message = '服务器内部异常';
            $this->status = 999;
            $this->recordErrorLog($e);
        }
        $result = [
            'message' => $this->message,
            'status' => $this->status,
        ];
        return json($result, $this->httpCode);
    }

    /**
     * 将异常写入日志
     * @param Exception $e
     */
    private function recordErrorLog(Exception $e)
    {
        $ip = $_SERVER['SERVER_ADDR'];
        $arr = ['11001', '40000','22000'];
        if (in_array($e->status, $arr)) {
            return true;
        }
        Log::init([
            'type' => 'File',
            'path' => Env::get('runtime_path') . 'error_log',
            'level' => ['error'],
        ]);
        Log::record($ip.$e->getMessage(), 'error');
    }
}