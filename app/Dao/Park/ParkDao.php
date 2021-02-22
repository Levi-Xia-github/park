<?php


namespace app\Dao\Park;

use app\Base\BaseDao;

class ParkDao extends BaseDao
{
    public $_cluster = 'park';
    public $_tbl = 'park_space';
    public $_pkey = 'spaceId';

    public $fields = ['spaceId','locId','address','desc','longitude','latitude','exact','facePic','picList','type','price','status','startTime','endTime','remark','createTime','updateTime'];


    public function getShareParkByIdList($IdList){
        $conds = [
            [$this->_pkey , 'in' , $IdList],
            ['type' , '=' , '0'],
            ['stat', '=' , '0'],
        ];
        $ret = $this->select($this->fields,$conds);
        return $ret;
    }
    /**
     * 后台获取共享车位
     */
    public function getShareParkForBk($start,$offset =20){
        $conds = [
            ['type' , '=' , '0'],
            ['stat', '=' , '0'],
        ];
        $limit = [$start,$start+$offset];
        $ret = $this->select($this->fields,$conds,$limit);
        return $ret;
    }
    public function addShareParkForBk($shareParkInfo){
        $ret = $this->insert($shareParkInfo);
        return $ret;
    }
}