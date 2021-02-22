<?php


namespace app\Service\Common;


use app\Base\BaseService;
use app\Dao\Common\PicServerDao;

class PicServerSerice extends BaseService
{
    public $_daoPicServer = Null;

    public function __construct()
    {
        $this->_daoPicServer = new PicServerDao();
    }

    public function addPic($picInfo){
        return $this->_daoPicServer->addPic($picInfo);
    }
}