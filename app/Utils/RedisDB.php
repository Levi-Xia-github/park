<?php
namespace app\Utils;

use think\facade\Config;

class  RedisDB{

    private $redis ; //redis对象

    /**
     * 初始化Redis
     * $config = array(
     *  'ip' => '127.0.0.1' 服务器
     *  'port'   => '6379' 端口号
     * )
     * @param array $config
     */
    function __construct(){
        $this ->redis = new \Redis();
        $hostname = config('redis.redis.hostname');
        $port = config('redis.redis.port');
        $this ->redis->connect($hostname,$port);
        return $this ->redis;
    }

    /**
     * 设置值
     * @param string $key KEY名称
     * @param string|array $value 获取得到的数据
     * @param int $timeOut 时间
     */
    public function set( $key , $value , $timeOut = 0, $type = 'json' ) {
        if ( $type == 'serialize' )
        {
            $value = serialize( $value );
        }
        else
        {
            $value = json_encode( $value );
        }

        $retRes = $this ->redis->set( $key , $value );
        if ( $timeOut > 0) $this ->redis->setTimeout( $key , $timeOut );
        return $retRes ;
    }

    /**
     * 通过KEY获取数据
     * @param string $key KEY名称
     */
    public function get( $key , $type = 'json' ) {
        $result = $this ->redis->get( $key );

        if ( $type == 'serialize' )
        {
            return unserialize( $result );
        }
        else
        {
            return json_decode( $result );
        }
    }

    /**
     * 删除一条数据
     * @param string $key KEY名称
     */
    public function delete ( $key ) {
        return $this ->redis-> delete ( $key );
    }

    /**
     * 清空数据
     */
    public function flushAll() {
        return $this ->redis->flushAll();
    }

    /**
     * 数据入队列
     * @param string $key KEY名称
     * @param string|array $value 获取得到的数据
     * @param bool $right 是否从右边开始入
     */
    public function push( $key , $value , $right = true) {
        $value = json_encode( $value );
        return $right ? $this ->redis->rPush( $key , $value ) : $this ->redis->lPush( $key , $value );
    }

    /**
     * 数据出队列
     * @param string $key KEY名称
     * @param bool $left 是否从左边开始出数据
     */
    public function pop( $key , $left = true) {
        $val = $left ? $this ->redis->lPop( $key ) : $this ->redis->rPop( $key );
        return json_decode( $val );
    }

    /**
     * 数据自增
     * @param string $key KEY名称
     */
    public function increment( $key ) {
        return $this ->redis->incr( $key );
    }

    /**
     * 数据自减
     * @param string $key KEY名称
     */
    public function decrement( $key ) {
        return $this ->redis->decr( $key );
    }

    /**
     * key是否存在，存在返回ture
     * @param string $key KEY名称
     */
    public function exists( $key ) {
        return $this ->redis->exists( $key );
    }

    /**
     * 返回redis对象
     * redis有非常多的操作方法，我们只封装了一部分
     * 拿着这个对象就可以直接调用redis自身方法
     */
    public function redis() {
        return $this ->redis;
    }

    /**
     * 添加一个geo数据
     * @param key 键名
     * @param longitude 经度坐标
     * @param latitude  纬度坐标
     */
    public function geoAdd($key , $longitude , $latitude , $name){
        return $this->redis->rawCommand('geoadd', $key, $longitude, $latitude, $name);
    }

    /**
     * 两地之间的直线距离
     * @param key 键名
     * @param name1 地点1
     * @param name2 地点2
     * @param unit 单位   m(米，默认)， km(千米)， mi(英里)， ft(英尺)
     */
    public function geoDist($key , $name1 , $name2 , $unit = 'm'){
        return $this->redis->rawCommand('geodist', $key, $name1, $name2, $unit);
    }
    /**
     * 获取某个地点的经纬坐标
     * @param key 键名
     * @param name 地点
     */
    public function geoPos($key , $name){
        return $this->redis->rawCommand('geopos', $key, $name);
    }

    /**
     * 获取成员的经纬度hash，geohash表示坐标的一种方法，便于检索和存储
     * @param key
     * @param 地点
     */
    public function getHash($key , $name){
        return $this->redis->rawCommand('geohash', $key , $name);
    }

    /**
     * 查询以经纬度为x,x为圆心，x千米范围内的成员
     * @param options // WITHCOORD 获取成员经纬度
     *                // WITHDIST  表示获取到圆心的距离
     *                // WITHHASH  表示获取成员经纬度HASH值
     *                // ASC 根据圆心位置，从近到远的返回元素
     *                // DESC 根据圆心位置，从远到近的返回元素
     */
    public function geoRadius($key , $longitude , $latitude , $range , $unit , $option , $order , $num = 50){
        return $this->redis->rawCommand('georadius', $key, $longitude , $latitude , $range , $unit , $option ,$order , 'COUNT',$num);
    }

    /**
     * COUNT,数量 表示限制获取成员的数量
     */
    public function geoCount($key , $longitude , $latitude , $range , $unit , $nums){
        return $this->redis->rawCommand('georadius', $key, $longitude , $latitude , $range , $unit , 'COUNT' ,$nums );
    }

    /**
     * 基于成员位置范围查询
     * 查询以name为圆心，range(unit)米范围内的成员
     */
    public function geoRadiusByMember($key , $name , $range , $unit='m'){
        return $this->redis->rawCommand('georadiusbymember', $key, $name, $range , $unit);
    }

    /**
     * 删除geo数据
     */
    public function geoZrem($key,$name){
        return $this->redis->rawCommand('Zrem', $key, $name);
    }

}

