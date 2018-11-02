<?php


namespace app\common\model;

use think\Model;

class BaseModel extends Model
{

    /**
     * 获取单条数据
     * @param string $field 查询的字段
     * @param string $where 查询条件
     * @param string $order 排序
     * @param bool $locak  是否加锁
     */
    public static function getOne($field = '*', $where = '', $order = '',$lock = false)
    {
        $return = self::field($field)
            ->where($where)
            ->order($order)
            ->lock($lock)
            ->find();

        return $return;
    }

    /**
     * 获取单条值数据
     * @param string $field 查询的字段
     * @param string $where 查询条件
     */
    public static function getValue($field = '*', $where = '')
    {
        return self::where($where)->value($field,0);
    }

    /**
     * 获取多条值数据
     * @param string $field 查询的字段
     * @param string $where 查询条件
     * @param string $order 排序
     * @param string $limit 行数
     */
    public static function getValues($field = '*', $where = '',$order = '',$limit = '')
    {
        return self::where($where)->order($order)->limit($limit)->value($field,0);
    }

    /**
     * 根据ID获取单条数据
     * @param string $field 查询的字段
     * @param string $id 查询条件
     */
    public static function getOneById($id = '', $field = '*')
    {
        $return = self::field($field)->where(['id' => $id])->find();
        return $return;
    }

    /**
     * 分页-获取多条数据
     * @param string $field 查询的字段
     * @param string $where 查询条件
     * @param string $order 排序
     * @param int $limit
     */
    public static function getPageList($field = '*', $where = '', $order = 'id desc', $limit = 5)
    {
        $return = self::field($field)
            ->where($where)
            ->order($order)
            ->paginate($limit);
        return $return;
    }

    /**
     * 获取数据列表
     * @param string $field 查询的字段
     * @param string $where 查询条件
     * @param string $order 排序
     */
    public static function getAll($field = '*', $where = '', $order = 'id desc',$group = '')
    {
        $return = self::field($field)
            ->where($where)
            ->order($order)
            ->group($group)
            ->select();
        return $return;
    }

    /**
     * 获取指定行数数据列表
     * @param string $field 查询的字段
     * @param string $where 查询条件
     * @param string $order 排序
     */
    public static function getLimitAll($field = '*', $where = '', $order = 'id desc',$group = '',$limit = 10)
    {
        $return = self::field($field)
            ->where($where)
            ->order($order)
            ->group($group)
            ->limit($limit)
            ->select();
        return $return;
    }

    /**
     * 数据新增
     * @param $data
     */
    public static function add($data, $field = true)
    {
        return self::create($data, $field);
    }

    /**
     * 根据主键id删除数据
     * @param $id
     */
    public static function delKey($id)
    {
        return self::destroy($id);
    }

    /**
     * 获取最大值
     * @param string $field 查询的字段
     * @param string $where 查询条件
     */
    public static function getMaxValue($field,$where)
    {
        $return = self::where($where)->max($field);
        return $return;
    }

    /**
     * 获取最小值
     * @param string $field 查询的字段
     * @param string $where 查询条件
     */
    public static function getMinValue($field,$where)
    {
        $return = self::where($where)->min($field);
        return $return;
    }

    /**
     * 算总
     * @param string $field 查询的字段
     * @param string $where 查询条件
     */
    public static function getSumValue($field,$where)
    {
        $return = self::where($where)->sum($field);
        return $return;
    }
}