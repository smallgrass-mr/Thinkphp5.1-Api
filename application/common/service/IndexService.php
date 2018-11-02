<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/14
 * Time: 13:51
 */

namespace app\common\service;

use app\common\lib\exception\ApiException;
use Error\ErrorCode;
use app\common\model\User;

class IndexService extends BaseService
{

    /**
     * test 逻辑处理
     */
    public function index(){
//        dump(ErrorCode::ERR_DATA_EDIT);die;
//          throw new ApiException(ErrorCode::ERR_DATA_EDIT);
          $result = User::getOne();
          return  $result ;
    }

}