<?php
namespace app\Utils;

class  ES{

    public $_es = NULL;
    public function __construct()
    {
        $hostname = config('es.es.hostname');
        $port = config('es.es.port');
        $params = [
            $hostname . ":" . $port,
        ];
        $this->_es = \Elasticsearch\ClientBuilder::create()->setHosts($params)->build();
    }
    public function getConn(){
        return $this->_es;
    }
}