<?php
/**
 * 文章逻辑层
 * author:yzb
 */

namespace app\common\service;

use app\common\lib\exception\ApiException;
use Error\ErrorCode;
use Error\ErrorMsg;
use app\common\model\Article;
use think\facade\Request;
use think\Db;

class ArticleService extends BaseService
{

    /**
     *  获取文章详情
     * author:yzb
     */
    public function getOneArticle($id){
        $field = 'id,name,title,sort,url';
        $result = Article::getOne($field,['id'=>$id]);
        if(empty($result)){
             throw new ApiException(ErrorMsg::getErrMsg(ErrorCode::ERR_DATA_NULL),200,40000);
        }
        return  $result ;
    }
}