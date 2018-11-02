<?php
/**
 * 文章表验证器
 * Author: yzb
 */

namespace app\common\validate;

class ArticleValidate extends BaseValidate
{

    /**
     * 定义验证的字段
     * @var array
     */
    protected $rule = [
        'id'           => 'require',
        'name|手机号'  => 'require',
        'title|标题' => 'require',
        'url|地址' => 'require',
        'status|状态' => 'require',
    ];

    /**
     * 定义场景验证
     * @var array
     */
    protected $scene = [
        'getone'        => ['id'],//获取文章详情
    ];
}
