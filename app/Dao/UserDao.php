<?php


namespace app\Dao;


use app\Base\BaseDao;

class UserDao extends BaseDao
{
    public $_cluster = 'tp_learn';
    public $_tbl = 'tp_user';
    public $_pkey = 'id';

    public function getUserInfo(){
        $fields = ['id','gender','userName','status'];
        $conds = [
            ['status','in',[1,2,3]],
            ['email','like','%163%'],
        ];
        $group = 'gender';
        $order = ['id'=>'asc', 'status'=>'asc'];
        $limit = [0,5];
        return $this->select($fields,$conds,$limit,$order,$group);
    }

    public function adduserInfo($userInfo){

        return $this->insert($userInfo);
    }

    public function updateUserInfo($id,$userInfo){
        return $this->update($id,$userInfo);
    }

    public function deleteUserInfo($conds){
        return $this->delete($conds);
    }

}