<?php
namespace app\controller;

use app\Base\BaseAction;
use app\Service\Search\SearchService;
use app\Utils\ES;

class Test extends BaseAction
{
//    private $_client = NULL;
//    private $_redis = NULL;
    private $_val = 123;
    protected  $_checkLogin = true;
    protected  $_needLogin = true;

    public function __construct()
    {
        parent::__construct();
        $this->_val = 456;
//        $this->_redis = new RedisDB();
//        $_es = new ES();
//        $this->_client = $_es->getConn();
    }
    public function index(){
        return $this->success([$this->_val]);
//        $redis = new RedisDB();
//        $redis->set('key',888);
//        return $redis->get('key');

//        $redis->flushAll();
//        die();

        //测试插入redis 地图数据
//        $redis->geoAdd('shareparkspace','116.407013','39.887611','100000000');
//        $redis->geoAdd('shareparkspace','116.422119','39.909736','100000001');
//        $redis->geoAdd('shareparkspace','116.408386','39.900255','100000002');
//        $redis->geoAdd('shareparkspace','116.516876','39.711413','100000003');

//        return json(ParkCommon::getDistanceOfTwoPosition('39.887611','116.407013','39.900255','116.408386'));


/*
        $params = [
            'index' => 'park',
            'body' => [
                'settings' => [
                    'number_of_shards' => 3,
                    'number_of_replicas' => 0,
                ],
                'mappings' => [

                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                            'spaceId' => [
                                'type' => 'keyword'
                            ],
                            'address' => [
                                'type' => 'text',
                            ],
                            'exact' => [
                                'type' => 'integer',
                            ],
                            'type' => [
                                'type' => 'integer',
                            ],
                            'price' => [
                                'type' => 'integer',
                            ],
                            'status' => [
                                'type' => 'integer',
                            ],
                            'startTime' => [
                                'type' => 'integer',
                            ],
                            'endTime' => [
                                'type' => 'integer',
                            ],
                            'stat' => [
                                'type' => 'integer',
                            ],
                            "location" => [
                                "type" => "geo_point"
                            ]
                        ],
                ],
            ]
        ];

        $response = $this->_client->indices()->create($params);
        return $this->success([
            'response' => $response
        ]);
*/

        /*
        $arr = [
            ['spaceId' => 100000000, 'address' => '北京市海淀区', 'exact' => 0, 'type' => 0, 'price' => 1999 ,'status' => 0 ,'startTime' => 134555,'endTime' => 18980,'stat' => 0,'location' =>['lat' => '39.887611','lon' => '116.407013'  ]],
            ['spaceId' => 100000001, 'address' => '北京市海淀区', 'exact' => 0, 'type' => 0, 'price' => 1998 ,'status' => 0 ,'startTime' => 134555,'endTime' => 18980,'stat' => 0,'location' =>['lat' => '39.909736','lon' => '116.422119'  ]],
            ['spaceId' => 100000002, 'address' => '北京市海淀区', 'exact' => 0, 'type' => 0, 'price' => 1997 ,'status' => 0 ,'startTime' => 134555,'endTime' => 18980,'stat' => 0,'location' =>['lat' => '39.900255','lon' => '116.408386'  ]],
            ['spaceId' => 100000003, 'address' => '北京市海淀区', 'exact' => 0, 'type' => 0, 'price' => 1996 ,'status' => 0 ,'startTime' => 134555,'endTime' => 18980,'stat' => 0,'location' =>['lat' => '39.711413','lon' => '116.516876'  ]],

        ];

        foreach ($arr as $key => $document) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'park',
                    '_id'    => $key
                ]
            ];

            $params['body'][] = [
                'spaceId'     => $document['spaceId'],
                'address'      => $document['address'],
                'exact'    => $document['exact'],
                'type' => $document['type'],
                'price'  => $document['price'],
                'status'  => $document['status'],
                'startTime'  => $document['startTime'],
                'endTime'  => $document['endTime'],
                'stat'  => $document['stat'],
                'location'  => $document['location'],
            ];
        }
        $response = '';
        if (isset($params) && !empty($params)) {
            $response = $this->_client->bulk($params);
        }
        return $this->success([
            'response' => $response
        ]);
        */


        /*
        $query = [
            "bool" => [
                "filter" => [
                    "geo_distance"=> [
                        "distance" => "4000m",
                        "location" => [
                            "lat" =>  39.867611,
                            "lon" => 116.39513,
                        ],
                    ]
                ]
            ]
        ];

        $dsl = [
            'index' => 'park',
            'type' => '_doc',
            '_source' => ['spaceId','address','stat','status'],
            'client' => [
                'timeout' => 1,
                'connect_timeout' => 0.5,
            ],
            'body' => array(
                'query' => $query,
            ),
        ];
        $response = $this->_client->search($dsl);
        return $this->success([
            'data' => $response,
        ]);
        */

        $_searchService = new SearchService();
        return $this->success([
            'data' => $_searchService->getPark()
        ]);
    }
}