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



}