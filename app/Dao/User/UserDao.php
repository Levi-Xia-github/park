<?php


namespace app\Dao\User;


use app\Base\BaseDao;

class UserDao extends BaseDao
{
    public $_cluster = 'park';
    public $_tbl = 'park_user';
    public $_pkey = 'userId';

    public $fields = ['userId','realName','passWord','mobile','cardType','cardId','createTime','updateTime'];


    public function getUserInfoById($userId){
        $conds = [
            [$this->_pkey,'=',$userId],
            ['stat','=',0],
        ];
        $limit = [0,1];
        $ret = $this->select($this->fields,$conds,$limit);
        return $ret;
    }
    public function getUserInfoByMobile($mobile){

        $conds = [
            ['mobile','=',$mobile],
            ['stat','=',0],
        ];
        $limit = [0,1];
        $ret = $this->select($this->fields,$conds,$limit);
        return $ret;
    }

}