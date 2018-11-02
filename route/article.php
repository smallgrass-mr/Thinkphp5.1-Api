<?php
// +----------------------------------------------------------------------
// | 关于 文章 路由
// +----------------------------------------------------------------------
// | Author: yangzhibin
// +----------------------------------------------------------------------
// | 说明: 新增:post 删除:del 修改:put 查询:get
// +----------------------------------------------------------------------
use think\facade\Route;
//空地址
Route::miss('api/Error/index');
//开启跨域请求
Route::header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept,Cache-Control,token')->allowCrossDomain();
//获取单条文章详情
Route::get('api/:version/article/one/:id', 'api/:version.Article/getOneArticle');
//Index test function 
Route::get('api/:version/test', 'api/:version.Index/test');
