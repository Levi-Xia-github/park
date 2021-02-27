<?php

namespace app\Service\User;

use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Base\BaseService;
use app\Dao\User\UserDao;

class UserService extends BaseService
{
    public $_daoUser = NULL;

    public function __construct()
    {
        $this->_daoUser = new UserDao();
    }

    public function getUserInfoById($userId){
        if(empty($userId)){
            throw new BaseException(BaseErrorCode::PARAM_ERROR);
        }
        $ret = $this->_daoUser->getUserInfoById($userId);
        return $ret;
    }

    public function getUserInfoByMobile($mobile){
        if(empty($mobile)){
            throw new BaseException(BaseErrorCode::PARAM_ERROR);
        }
        $userInfo  = $this->_daoUser->getUserInfoByMobile($mobile);
        return $userInfo;
    }



}