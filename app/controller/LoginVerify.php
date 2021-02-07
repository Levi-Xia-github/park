<?php

namespace app\controller;

use app\Base\BaseAction;
use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Common\Passport;
use app\Service\User\UserService;
use think\facade\Cookie;

/**
 * Class LoginVerify
 * @package app\controller
 * @desc 手机号，密码式获取token
 */
class LoginVerify extends BaseAction
{
    protected  $_checkLogin = false;
    protected  $_needLogin = false;

    public function index(){
        $_serviceUser = new UserService();

        $mobile = $this->_getInput('mobile',0);
        $passWord = $this->_getInput('passWord',0);

        if(empty($mobile) || empty($passWord)){
            throw new BaseException(BaseErrorCode::PARAM_ERROR);
        }
        $ret = $_serviceUser->getUserInfoByMobile($mobile);
        $userInfo = $ret[0];
        if(empty($userInfo)){
            throw new BaseException(BaseErrorCode::USER_NOT_REGISTER);
        }
        //$hash_password = password_hash($passWord, PASSWORD_BCRYPT);
        if (password_verify($passWord , $userInfo['passWord'])){
            $userId = $userInfo['userId'];
            $accessToken = Passport::createUserToken(123456,$userId);
            Cookie::set('ATK',$accessToken);
            return $this->success(true);
        }else {
            return $this->success(false);
        }

    }
}