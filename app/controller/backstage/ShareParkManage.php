<?php


namespace app\controller\backstage;


use app\Base\BaseAction;
use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Service\Park\ParkService;

class ShareParkManage extends BaseAction
{
    protected  $_checkLogin = true;
    protected  $_needLogin = true;

    public function index(){

        $_parkSrvice = new ParkService();

        $command = $this->_getInput('command','view');

        switch ($command){

            case 'add':
                $address = $this->_getInput('address','');
                $desc = $this->_getInput('desc','');
                $longitude = $this->_getInput('longitude',0);
                $latitude = $this->_getInput('latitude',0);
                $exact = $this->_getInput('exact',0) ?? 0;
                $picList = $this->_getInput('picList','');
                $price = $this->_getInput('price',0);
                $remark = $this->_getInput('remark','');
                if(empty($address) || empty($longitude) || empty(($latitude) || empty($picList) || $price) || empty($remark) || empty($desc)){
                    throw new BaseException(BaseErrorCode::PARAM_ERROR);
                }
                $picArr = explode('#',$picList);
                $facePic = $picArr[0];
                $_parkSrvice->addShareParkForBk($address,$desc,$longitude,$latitude,$picList,$price,$remark,$facePic,$exact);
                break;
            case 'delete':
                break;
        }

        $shareParkList = $_parkSrvice->getShareParkForBk();
        $data = [
            'shareParkList' => $shareParkList,
        ];

        return $this->success($data,'backstage/sharepark/parkmanage');
    }
}