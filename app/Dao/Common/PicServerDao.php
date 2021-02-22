<?php


namespace app\Dao\Common;


use app\Base\BaseDao;

class PicServerDao extends BaseDao
{
    public $_cluster = 'park';
    public $_tbl = 'picServer';
    public $_pkey = 'id';

    public $fields = ['id','name','type','imgdata','fkey'];

    public function addPic($picInfo){
        $ret = $this->insert($picInfo);
        return $ret;
    }
}