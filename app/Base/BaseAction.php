<?php

namespace app\Base;

use app\BaseController;
use app\Common\Passport;
use think\App;
use think\Exception;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\View;

class BaseAction extends BaseController
{
    protected  $_checkLogin = false;
    protected  $_needLogin = false;
    protected  $_userId = 0;

    public function __construct()
    {
        self::_login();
        self::_checkLogin();
    }

    public function _getInput($input,$default=''){
        if(empty($input)){
            return ;
        }
        $ret = Request::param($input);
        if(empty($ret) && !empty($default)){
            return $default;
        }else if(empty($ret) && empty($default)){
            return ;
        }
        return $ret;
    }

    public function success($paramArr=[],$view=''){
        if(!is_array($paramArr)){
            throw new BaseException(BaseErrorCode::PARAM_ERROR);
        }
        if(empty($view)){
            $output = [];
            $output['errCode'] = 0;
            $output['errMsg'] = 'ok';
            $output['data'] = $paramArr;
            return json($output);
        }
        return View::fetch($view,$paramArr);
    }

    protected function _login()
    {
        if (!$this->_needLogin && !$this->_checkLogin) {
            return;
        }
        $accessToken = Cookie::get('ATK');
        if (empty($accessToken)) {
            return;
        }
        $userInfo = Passport::translateUserToken($accessToken);
        $this->_userId = $userInfo['userId'];
    }

    protected function _checkLogin() {
        if ($this->_checkLogin && empty($this->_userId)) {
            throw new BaseException(BaseErrorCode::USER_NOT_LOGIN);
        }
        return;
    }

}