<?php


namespace app\Dao\Search;


use app\Base\BaseDao;
use app\Utils\ES;

class SearchDao extends BaseDao
{
    private $_client = NULL;
    public function __construct(){

        $_es = new ES();
        $this->_client = $_es->getConn();
    }


    /**
     * @desc 根据距离寻找合适的车位
     */
    public function getParkList($distance,$latitude,$longitude,$boundaryId = 0,$num = 0 ,$type = 0,$status=0){
        $query = [
            "bool" => [
                "must" => [
                    [
                        'term' => [
                            'stat' => 0 ,
                        ],
                    ],
                    [
                        'term' => [
                            'status' => $status,
                        ],
                    ],
                    [
                        'term' => [
                            'stat' => 0,
                        ],
                    ],
                    [
                        'term' => [
                            'type' => 0,
                        ],
                    ],
                ],
                "filter" => [
                    "geo_distance"=> [
                        "distance" => $distance.'m',
                        "location" => [
                            "lat" =>  $latitude,
                            "lon" => $longitude,
                        ],
                    ]
                ]
            ]
        ];

        $dsl = [
            'index' => 'park',
            'type' => '_doc',
            '_source' => ['spaceId','location'],
            'client' => [
                'timeout' => 1,
                'connect_timeout' => 0.5,
            ],
            'body' => array(
                'from' => $boundaryId,
                'size' => $num,
                'query' => $query,
            ),
        ];
//        return json_encode($dsl);
        $ret = $this->_client->search($dsl);
        $total = $ret['hits']['total'];
        $hits = $ret['hits']['hits'];
        $response = $this->getSource($ret, ['spaceId','location']);
        return [
            'spaceIdList' => $response['spaceId'] ,
            'spaceLocationList' => $response['location'] ,
            'boundaryId' => $boundaryId + $num,
            'isEnd' => count($response['spaceId']) == $num ? false : true,
        ];
    }

    private function getSource($hits, $sourceList) {
        $output = [];
        foreach ($sourceList as $list) {
            $output[$list] = [];
        }
        $hits = $hits['hits']['hits'];
        foreach ($hits as $value) {
            foreach ($value['_source'] as $source => $va) {
                if (in_array($source, $sourceList)) {
                    $output[$source][] = $va;
                }
            }
        }
        return $output;
    }

    public function addPark($addInfoList){
        foreach ($addInfoList as $key => $document) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'park',
                    '_id' => $document['spaceId'],
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
        return $response;
    }

}