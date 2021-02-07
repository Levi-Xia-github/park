<?php

namespace app\Service;

use app\Base\BaseService;
use app\Dao\UserDao;

class UserService extends BaseService
{
    public $_daoUser = NULL;

    public function __construct()
    {
        $this->_daoUser = new UserDao();
    }

    public function select(){
        return $this->success($this->_daoUser->getUserInfo());
    }

    public function find($id){
        return  $this->success($this->_daoUser->find($id));
    }

    public function insert(){
        $userInfo = [
            'id'    =>     111,
            'username'     => '夏文杨',
        ];
        return  $this->success($this->_daoUser->adduserInfo($userInfo));
    }

    public function query($sql){
        return $this->success($this->_daoUser->query($sql));
    }

    public function update($id,$userInfo){
        return $this->success($this->_daoUser->updateUserInfo($id,$userInfo));
    }

    public function delete($conds){
        return $this->success($this->_daoUser->deleteUserInfo($conds));
    }

}