<?php


namespace app\Dao\Park;

use app\Base\BaseDao;

class ParkDao extends BaseDao
{
    public $_cluster = 'park';
    public $_tbl = 'park_space';
    public $_pkey = 'spaceId';

    public $fields = ['spaceId','locId','address','desc','longitude','latitude','exact','facePic','picList','type','price','status','startTime','endTime','remark','createTime','updateTime'];

    public function getShareParkInfoById($spaceId){
        $conds = [
            [$this->_pkey , '=' , $spaceId],
            ['stat', '=' , '0'],
        ];
        $ret = $this->select($this->fields,$conds);
        return $ret;
    }

    public function getShareParkByIdList($IdList){
        $conds = [
            [$this->_pkey , 'in' , $IdList],
            ['type' , '=' , '0'],
            ['status' ,'=' , '0'],
            ['stat', '=' , '0'],
        ];
        $ret = $this->select($this->fields,$conds);
        return $ret;
    }

    /**
     * 获取超时未还的共享车位
     */
    public function getTimeoutShareParkList($sortId,$limit=20){
        $conds = [
            ['spaceId' , '<' , $sortId],
            ['type' , '=' , '0'],
            ['status' ,'=' , '3'],
            ['stat', '=' , '0'],
        ];
        $order = ['spaceId' => 'desc'];
        $limitQ = [0,$limit];
        $ret = $this->select($this->fields,$conds,$limitQ,$order);
        return $ret;
    }
    /**
     * 后台获取共享车位
     */
    public function getShareParkForBk($limit =20){
        $conds = [
            ['type' , '=' , '0'],
            ['status' ,'=' , '0'],
            ['stat', '=' , '0'],
        ];
        $limitQ = [0,$limit];
        $ret = $this->select($this->fields,$conds,$limitQ);
        return $ret;
    }
    public function addShareParkForBk($shareParkInfo){
        $ret = $this->insert($shareParkInfo);
        return $ret;
    }
}