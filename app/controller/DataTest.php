<?php


namespace app\controller;

use app\Base\BaseAction;
use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Common\Passport;
use app\Service\User\UserService;
use app\Utils\ES;
use think\App;

class DataTest extends BaseAction
{
    protected  $_checkLogin = true;
    protected  $_needLogin = true;

    public function index(){
        $_serviceUser = new UserService();
        $es = new ES();
        $client = $es->getConn();
//        $params = [
//            'index' => 'users',
//            'body' => [
//                'settings' => [
//                    'number_of_shards' => 3,
//                    'number_of_replicas' => 2
//                ],
//                'mappings' => [
//                    '_source' => [
//                        'enabled' => true
//                    ],
//                    'properties' => [
//                        'name' => [
//                            'type' => 'keyword'
//                        ],
//                        'age' => [
//                            'type' => 'integer'
//                        ],
//                        'mobile' => [
//                            'type' => 'text'
//                        ],
//                        'email' => [
//                            'type' => 'text'
//                        ],
//                        'birthday' => [
//                            'type' => 'date'
//                        ],
//                        'address' => [
//                            'type' => 'text'
//                        ]
//                    ]
//                ]
//            ]
//        ];

//        $response = $client->indices()->create($params);
//        $params = [
//            'index' => 'users',
//            'id'    => 1,
//            'body'  => [
//                'name'     => '张三',
//                'age'      => 10,
//                'email'    => 'zs@gmail.com',
//                'birthday' => '1990-12-12',
//                'address'  => '北京'
//            ]
//        ];
//        $client->index($params);

//        $arr = [
//            ['name' => '张三', 'age' => 10, 'email' => 'zs@gmail.com', 'birthday' => '1990-12-12', 'address' => '北京'],
//            ['name' => '李四', 'age' => 20, 'email' => 'ls@gmail.com', 'birthday' => '1990-10-15', 'address' => '河南'],
//            ['name' => '白兮', 'age' => 15, 'email' => 'bx@gmail.com', 'birthday' => '1970-08-12', 'address' => '杭州'],
//            ['name' => '王五', 'age' => 25, 'email' => 'ww@gmail.com', 'birthday' => '1980-12-01', 'address' => '四川'],
//        ];
//
//        foreach ($arr as $key => $document) {
//            $params['body'][] = [
//                'index' => [
//                    '_index' => 'users',
//                    '_id'    => $key
//                ]
//            ];
//
//            $params['body'][] = [
//                'name'     => $document['name'],
//                'age'      => $document['age'],
//                'email'    => $document['email'],
//                'birthday' => $document['birthday'],
//                'address'  => $document['address']
//            ];
//        }
//        if (isset($params) && !empty($params)) {
//            $client->bulk($params);
//        }

//        $params = [
//            'index' => 'users',
//            'id'    => 1
//        ];
//        $response = $client->get($params);

        $must = array(
            array(
                'match' => array(
                    'email' => 'zs',
                ),
            ),
        );
        $filter = array(
            'range' => array(
                'age' => array(
                    'lte' => 22,
                ),
            ),
        );

        $query = array(
            'bool' => array(
                'must' => $must,
//                'filter' => $filter,
            ),
        );

        $sort = array(
            array(
                'age' => array(
                    'order' => 'asc',
                ),
            ),
        );

        $dsl = array(
            'index' => 'users',
            'type' => '_doc',
            '_source' => [
                'name',
                'age',
                'email',
                'birthday',
                'address'
            ],
            'client' => [
                'timeout' => 1,
                'connect_timeout' => 0.5,
            ],
            'body' => array(
                'size' => 10,
                'query' => $query,
//                'sort' => $sort,
                'highlight' => array(
                    'pre_tags' => ["<em>"],
                    'post_tags' => ["</em>"],
                    'fields' => array(
                        'email' => new \stdClass(),
                    ),
                ),
            ),
        );
//        return $this->success($dsl);
        $response = $client->search($dsl);
        return $this->success([
            'response' => $response,
        ]);
    }
}