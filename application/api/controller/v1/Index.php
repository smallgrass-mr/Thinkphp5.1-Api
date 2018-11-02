<?php
namespace app\api\controller\v1;

use app\common\service\IndexService;
use app\common\nosql\HomePage;
use Error\ErrorCode;
class Index
{
    /**
     * 测试模块搭建方法
     * author:yzb
     */
    public function index()
    {
        //获取服务数据
        $result = (new IndexService())->index();
        //获取缓存数据
        //$result = (new HomePage())->getHomePageList('ME');
        if(!empty($result)){
              return show(['status' => 10000,'data' => $result]);
        }
        return show(['status' => ErrorCode::ERR_DATA_NULL]);   
    }
    
}
