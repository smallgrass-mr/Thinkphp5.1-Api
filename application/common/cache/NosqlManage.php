<?php
/**
 * 非关系型数据库
 * User: Administrator
 * Date: 2018/11/1
 * Time: 10:01
 */

namespace app\common\cache;


use app\common\lib\exception\ApiException;
use Error\ErrorCode;
class NoSqlManage
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

    /******************** 交易买缓存开始 ***********************/
    const BUY = 'trade_buy_';

    private  function getTradeBuyKey($key)
    {
        return $this->setKey(self::BUY . $key);
    }

    public function getTradeBuy($key)
    {
        return $this->get($this->getTradeBuyKey($key));
    }

    public function setTradeBuy($key, $data, $expire = 0)
    {
        return $this->set($this->getTradeBuyKey($key), $data, $expire);
    }

    public function delTradeBuy($key)
    {
        return $this->delete($this->getTradeBuyKey($key));
    }
    /******************** 交易买缓存结束 **********************/

    /******************** 交易卖缓存开始 ***********************/
    const SELL = 'trade_sell_';

    private  function getTradeSellKey($key)
    {
        return $this->setKey(self::SELL . $key);
    }

    public  function getTradeSell($key)
    {
        return $this->get($this->getTradeSellKey($key));
    }

    public  function setTradeSell($key, $data, $expire = 0)
    {
        return $this->set($this->getTradeSellKey($key), $data, $expire);
    }

    public  function delTradeSell($key)
    {
        return $this->delete($this->getTradeSellKey($key));
    }
    /******************** 交易卖缓存结束 **********************/

	

    /******************** 防止用户重复提交开始 ***********************/
    const REPETITION = 'user_repetition';
    private function getUserRepetitionKey($key)
    {
        return $this->setKey(self::REPETITION . $key);
    }

    public  function getUserRepetition($key = '')
    {
        return $this->get($this->getUserRepetitionKey($key));
    }

    public  function setUserRepetition($key = '',$data,$expire = 0)
    {
        return $this->set($this->getUserRepetitionKey($key), $data,$expire);
    }

    public  function delUserRepetition($key = '')
    {
        return $this->delete($this->getUserRepetitionKey($key));
    }
    /******************** 防止用户重复提交结束 ***********************/

    /******************** 文件详情地址开始 ***********************/
    const ARTICLE = 'article_info';
    private function getArticleInfoKey($key)
    {
        return $this->setKey(self::ARTICLE . $key);
    }

    public  function getArticleInfo($key = '')
    {
        return $this->get($this->getArticleInfoKey($key));
    }

    public  function setArticleInfo($key = '',$data,$expire = 0)
    {
        return $this->set($this->getArticleInfoKey($key), $data,$expire);
    }

    public  function delArticleInfo($key = '')
    {
        return $this->delete($this->getArticleInfoKey($key));
    }
    /******************** 防止用户重复提交结束 ***********************/
    /**
     * 查看 Redis 是否连接成功，正常返回 +PONG
     */
    private function ping()
    {
        return $this->redis->ping();
    }

    /**
     * 设置值，成功返回 true，失败返回false
     */
    public function set($key, $value, $express = 0)
    {
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
        return $this->redis->hLen($key);
    }

    /**
     * 获取在哈希表中指定 key 的所有字段和值
     */
    public function hGetAll($key)
    {
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
     * 删除哈希key。
     * @param $key
     * @return int
     */
    public function hDel($key,$hashKey)
    {
        return $this->redis->hDel($key,$hashKey);
    }

    /**
     * 设置值，如果$key存在数据库，返回false，设置成功返回 true，失败返回false
     */
    private function setnx($key, $value)
    {
        return $this->redis->setnx($key, $value);
    }

    /**
     * 获取值，不存在返回false
     */
    public function get($key)
    {
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
    private function delete($key)
    {
        return $this->redis->delete($key);
    }

    /**
     * 判断值是否存在，存在返回true，不存在返回false
     */
    private function exists($key)
    {
        return $this->redis->exists($key);
    }

    /**
     * $key 自增1
     */
    public function incr($key)
    {
        return $this->redis->incr($key);
    }

    /**
     * $key 自减1
     */
    public function decr($key)
    {
        return $this->redis->decr($key);
    }

    /**
     * 队列入列
     */
    public function rPush($key,$value)
    {
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
    private function setKey($key)
    {
        return md5($key . '_Redis');
    }

    /**
     * redis 计数器
     */
    public function counter($key)
    {
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
     * 更新缓存时间
     * @param $key
     * @param $expire
     */
    public function updateExpire($key,$expire)
    {
        $this->redis->Expire($key,$expire);
    }

    /**
     * 清除所有redis 数据
     */
    public function delAll()
    {
        $this->redis->flushAll();
    }

}