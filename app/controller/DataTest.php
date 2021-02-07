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

//       $id = $this->_getInput('id',0);
        return $this->success($this->_userId);
//        return $_serviceUser->delete(
//            [
//                ['id','<',25],
//            ]);
//       return $_serviceUser->update(301,['username' =>  '帅哥','password' => 666]);
//       return $_serviceUser->query('select * from tp_user limit 2 ');
//       return $_serviceUser->insert();
//       return $_serviceUser->find($id);
//       return $_serviceUser->select();

    }
}