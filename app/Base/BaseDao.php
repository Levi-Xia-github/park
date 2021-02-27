<?php

namespace app\Base;

use think\Exception;
use think\facade\Db;


class BaseDao
{
    public $_cluster = '';
    public $_tbl = '';
    public $_pkey = '';

    public function getDb()
    {
        return  Db::connect($this->_cluster)->table($this->_tbl);
    }

    public function find($id){
        $_dbConn = self::getDb();
        return $_dbConn->where($this->_pkey,$id)->find()->toArray();
    }

    public function select($fields , $conds = NULL , $limit= NULL , $order= NULL , $group = NULL){
        $_dbConn = self::getDb();
        $ret = $_dbConn;
        !empty($fields) && $ret = $ret->field($fields);
        !empty($conds) && $ret = $ret->where($conds);
        !empty($group) && $ret = $ret->group($group);
        !empty($order) && $ret = $ret->order($order);
        !empty($limit) && $ret = $ret->limit($limit[0],$limit[1]);
        $ret = $ret->select()->toArray();
        //return DB::getLastSql();
        return $ret;
    }

    public function insert($row){
        $_dbConn = self::getDb();
        $_dbConn->insert($row);
        return $_dbConn->getLastInsID();
    }

    public function query($sql){
       return Db::query($sql);
    }

    public function exec($sql){
        return  Db::execute($sql);
    }

    public function update($id,$row){
        $_dbConn = self::getDb();
        $ret = $_dbConn->where($this->_pkey,'=',$id)->update($row);
        return $ret;
    }

    public function delete($conds){
        $_dbConn = self::getDb();
        $ret = $_dbConn->where($conds)->delete();
        return $ret;
    }

    public function insertAll($rows){

    }

    public function chunkSelect(){

    }

}