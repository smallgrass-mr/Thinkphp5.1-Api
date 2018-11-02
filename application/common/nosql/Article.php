<?php

//----------------------------------
//文章缓存层
//Author zyb
//----------------------------------
namespace app\common\nosql;

use app\common\model\Article as ArticleModel;

class Article extends Base 
{
    const  ARTICLE = "article";
     /**
     * 获取首页数据
     * @param string $id 文章id
     * @return json
     * @author yangzhibin
     */
    public function getOneArticle($id)
    {
        $result = self::get(self::ARTICLE.$id);
        if(!$result){
            $field = 'id,name,title,url,status,sort';
            $result = ArticleModel::getOne($field, ['id' => $id]);
            if($result){
                self::set(self::ARTICLE.$id,$result,10);
            }
        }
        return $result ? $result : '';
    }
}