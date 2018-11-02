<?php
namespace app\api\controller\v1;

use Error\ErrorCode;
use app\common\nosql\HomePage;
use app\common\validate\ArticleValidate;
use app\common\service\ArticleService;
use app\common\nosql\Article as ArticleNosql;

class Article
{   
    /**
     * @param Int $id 文章id
     * 获取文章详情
     * authour yzb 
     */
    public function getOneArticle($id){
        $artvalidate  = (new ArticleValidate() ) ;
        $artvalidate->goCheck('getone');
        //加redis缓存 取文章
        $result = (new ArticleNosql())->getOneArticle($id);
        //不加缓存
//        $result = (new ArticleService())->getOneArticle($id);
        if(!empty($result)){
              return show(['status' => 10000,'data' => $result]);
        }
        return show(['status' => ErrorCode::ERR_DATA_NULL]);
    }
}
