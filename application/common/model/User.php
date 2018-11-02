<?php


namespace app\common\model;

use think\Model;

class User extends BaseModel
{
    //开启时间戳字段更新
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'addtime';
    protected $updateTime = 'endtime';
    //注册一个事件观察者：
    // protected $observerClass = 'app\common\event\User';

    
}