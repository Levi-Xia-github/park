<?php


namespace app\Service\Order;


use app\Base\BaseService;

class OrderService extends BaseService
{
    public $_daoOrder = Null;

    public function __construct()
    {
        $this->_daoOrder = new OrderDao();
    }
}