<?php


namespace app\controller;


use app\Base\BaseAction;
use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Service\Park\ParkService;
use app\Service\User\UserService;

class ShareParkDetails extends BaseAction
{
    protected  $_checkLogin = true;
    protected  $_needLogin = true;

    public function index()
    {
        $_parkService = new ParkService();
        $_userService = new UserService();

        $spaceId = $this->_getInput('spaceId',0);

        if(empty($spaceId)){
            throw new BaseException(BaseErrorCode::PARAM_ERROR);
        }

        $shareParkInfo = $_parkService->getShareParkInfoById($spaceId);

        $output = [
            'shareParkInfo' => $shareParkInfo,
        ];
        return $this->success($output);
    }
}