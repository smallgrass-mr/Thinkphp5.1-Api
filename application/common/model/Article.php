<?php


namespace app\common\model;

use think\Model;

class Article extends BaseModel
{
    //开启时间戳字段更新
    protected $autoWriteTimestamp = true;
    // 定义时间戳字段名
    protected $createTime = 'addtime';
    //注册一个事件观察者：
    // protected $observerClass = 'app\common\event\User';

    
}