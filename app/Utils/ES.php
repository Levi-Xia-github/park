<?php
namespace app\Utils;
require '../vendor/autoload.php';
class  ES{

    private $es = NULL;
    public function __construct()
    {
        //host数组可配置多个节点
        $params = array(
            '127.0.0.1:9200'
        );
        $this->es = \Elasticsearch\ClientBuilder::create()->setHosts($params)->build();
    }

    public function getConn(){
        return $this->es;
    }
}