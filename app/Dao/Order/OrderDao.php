<?php


namespace app\Dao\Order;


use app\Base\BaseDao;

class OrderDao extends BaseDao
{
    public $_cluster = 'park';
    public $_tbl = 'park_order';
    public $_pkey = 'orderId';

    public $fields = ['orderId','sellerId','userId','spaceId','orderTime','orderStatus','payStatus','payTime','finishTime','parkPrice','type','createTime','updateTime'];

}