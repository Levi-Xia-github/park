<?php


namespace app\controller\backstage;


use app\Base\BaseAction;
use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Service\Park\ParkService;
use app\Service\Search\SearchService;
use app\Utils\ES;

/**
 * 后台发布共享车位e
 */
class ShareParkManage extends BaseAction
{
    protected  $_checkLogin = true;
    protected  $_needLogin = true;

    private $_parkService = NULL;
    private $_searchService = NULL;
    private $_client = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->_parkService = new ParkService();
        $_es =  new ES();
        $this->_client = $_es->getConn();
        $this->_searchService = new SearchService();
    }

    public function index(){

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
                $insertId = $this->_parkService->addShareParkForBk($address,$desc,$longitude,$latitude,$picList,$price,$remark,$facePic,$exact);

                //添加到es中去
                if(empty($insertId)){
                    throw new BaseException(BaseErrorCode::REQUEST_ERROR);
                }
                $this->_searchService->addPark($insertId,$address,$price,$longitude,$latitude,$exact);
                break;
            case 'delete':
                break;
        }

        $shareParkList = $this->_parkService->getShareParkForBk();
        $data = [
            'shareParkList' => $shareParkList,
        ];

        return $this->success($data,'backstage/sharepark/parkmanage');
    }

}