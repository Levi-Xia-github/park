<?php


namespace app\controller;

use app\Base\BaseAction;
use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Common\Passport;
use app\Service\UserService;
use think\App;

class DataTest extends BaseAction
{
    protected  $_checkLogin = true;
    protected  $_needLogin = true;

    public function index(){

       $_serviceUser = new UserService();
       
    }
}