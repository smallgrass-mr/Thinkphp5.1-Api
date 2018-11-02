<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Data 2018/11/01 10:19
// +----------------------------------------------------------------------

namespace app\common\nosql;

use app\common\lib\exception\ApiException;
use Error\ErrorCode;
class Base
{
    private  $redis;
    public function __construct()
    {
        $config = config('redis.');
        if (!is_object($this->redis)) {
            try {
                $this->redis = new \Redis();
                $this->redis->connect($config['host'],$config['port'],$config['timeout']);
                $this->redis->auth($config['password']);
            } catch (\Exception $e) {
                throw new ApiException(ErrorCode::ERR_CACHE);
            }
        }
    }


    /**
     * 设置值，成功返回 true，失败返回false
     */
    public function set($key, $value, $express = 0)
    {
        $key = $this->setKey($key);
        if (is_array($value) || is_object($value)) {
            $value = serialize($value);
        }
        if ($express) {
            return $this->redis->setex($key, $express, $value);
        } else {
            return $this->redis->set($key, $value);
        }
    }

    /**
     * 存储哈希数据
     * @param $key
     * @param $hashkey
     * @param $value
     * @return int
     */
    public function hSet($key, $hashkey,$value)
    {
        $key = $this->setKey($key);
        if (is_array($value) || is_object($value)) {
            $value = serialize($value);
        }
        return $this->redis->hSet($key,$hashkey,$value);
    }

    /**
     * 获取哈希数据
     * @param $key
     * @param $hashkey
     * @return mixed|string
     */
    public function hGet($key, $hashkey)
    {
        $key = $this->setKey($key);
        $value = $this->redis->hGet($key, $hashkey);
        if ($value) {
            $values = @unserialize($value);
            if (is_object($values) || is_array($values)) {
                return $values;
            }
            return $value;
        } else {
            return $value;
        }
    }

    /**
     * 获取哈希表中字段的数量。
     * @param $key
     * @return int
     */
    public function hLen($key)
    {
        $key = $this->setKey($key);
        return $this->redis->hLen($key);
    }

    /**
     * 获取在哈希表中指定 key 的所有字段和值
     */
    public function hGetAll($key)
    {
        $key = $this->setKey($key);
        $value = $this->redis->hGetAll($key);
        if ($value) {
            $values = @unserialize($value);
            if (is_object($values) || is_array($values)) {
                return $values;
            }
            return $value;
        } else {
            return $value;
        }
    }

    /**
     * 查看哈希表的指定字段是否存在。
     */
    public function hExists($key,$hashkey)
    {
        $key = $this->setKey($key);
       return $this->redis->hExists($key,$hashkey);
    }

    /**
     * 获取哈希表种指定哈希下的所有key
     */
    public function hKeys($key)
    {
        $key = $this->setKey($key);
        return $this->redis->hKeys($key);
    }

    /**
     * 删除哈希key。
     * @param $key
     * @return int
     */
    public function hDel($key,$hashKey)
    {
        $key = $this->setKey($key);
        return $this->redis->hDel($key,$hashKey);
    }

    /**
     * 设置值，如果$key存在数据库，返回false，设置成功返回 true，失败返回false
     */
    private function setnx($key, $value)
    {
        $key = $this->setKey($key);
        return $this->redis->setnx($key, $value);
    }

    /**
     * 获取值，不存在返回false
     */
    public function get($key)
    {
        $key = $this->setKey($key);
        $value = $this->redis->get($key);
        if ($value) {
            $values = @unserialize($value);
            if (is_object($values) || is_array($values)) {
                return $values;
            }
            return $value;
        } else {
            return $value;
        }
    }

    /**
     * 删除值，返回受影响的行数
     */
    public function delete($key)
    {
        $key = $this->setKey($key);
        return $this->redis->delete($key);
    }

    /**
     * 判断值是否存在，存在返回true，不存在返回false
     */
    public function exists($key)
    {
        $key = $this->setKey($key);
        return $this->redis->exists($key);
    }

    /**
     * 设置key 的过期时间
     */
    public function expire($key,$time)
    {
        $key = $this->setKey($key);
        return $this->redis->expire($key,$time);
    }

    /**
     * $key 自增1
     */
    public function incr($key)
    {
        $key = $this->setKey($key);
        return $this->redis->incr($key);
    }

    /**
     * $key 自减1
     */
    public function decr($key)
    {
        $key = $this->setKey($key);
        return $this->redis->decr($key);
    }

    /**
     * 队列入列
     */
    public function rPush($key,$value)
    {
        $key = $this->setKey($key);
        if (is_array($value) || is_object($value)) {
            $value = serialize($value);
        }
        return $this->redis->rPush($key,$value);
    }

    /**
     * 队列出列
     */
    public function lPop($key)
    {
        $key = $this->setKey($key);
        $value =  $this->redis->lPop($key);
        if ($value) {
            $values = @unserialize($value);
            if (is_array($values) || is_object($values)) {
                return $values;
            }
            return $value;
        } else {
            return $value;
        }

    }

    /**
     * @param $key
     * @return string
     */
    public function setKey($key)
    {
        return md5($key . '_Redis');
    }

    /**
     * redis 计数器
     */
    public function counter($key)
    {
        $key = $this->setKey($key);
        $count = $this->redis->incr($key);
        if($count == 1){
            $this->redis->expire($key,60);//设置过期时间
        }
        if($count > 200){
            return false;
        }
        return true;
    }

    /**
     * 清除所有redis 数据
     */
    public function delAll()
    {
        $this->redis->flushAll();
    }

}