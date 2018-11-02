<?php
//----------------------------------
//首页缓存层
//----------------------------------
//Date  2018-11-1
//----------------------------------
//Author zyb
//----------------------------------

namespace app\common\nosql;

use app\common\model\Article;

class HomePage extends Base 
{
    const  HOME_PAGE = "homepage";
    const  MENUS = "menus";
     /**
     * 获取首页数据
     * @param string $menu_name 名称
     * @return json
     * @author yangzhibin
     */
    public function getHomePageList($menu_name)
    {
        $result = self::get(self::HOME_PAGE.$menu_name);
        if(!$result){
            $field = 'id,name,title,url,status,sort';
            $result = Article::getAll($field, ['status' => 1, 'name' => $menu_name], 'sort asc')->toArray();
            if($result){
                self::set(self::HOME_PAGE.$menu_name,$result,10);
            }
        }
        return $result ? $result : '';
    }
}