<?php


namespace app\Service\Search;


use app\Base\BaseService;
use app\Dao\Search\SearchDao;

class SearchService extends BaseService
{
    public $_daoSearch = Null;

    public function __construct()
    {
        $this->_daoSearch = new SearchDao();
    }

    public function getParkList($distance,$latitude,$longitude,$boundaryId=0,$num= 0,$type=0,$status=0){
        empty($boundaryId) && $boundaryId = 0;
        empty($num) && $num = 20;
        $ret =  $this->_daoSearch->getParkList($distance,$latitude,$longitude,$boundaryId,$num,$type,$status);
        return$ret;
    }

    public function addPark($spaceId,$address,$price,$longitude,$latitude,$exact=0,$type=0,$status=0){
        $addInfoList = [
            [
                'spaceId' => $spaceId,
                'address' => $address,
                'exact' => $exact,
                'type' => $type,
                'price' => $price ,
                'status' => $status,
                'startTime' => 0,
                'endTime' => 0,
                'stat' => 0,
                'location' => [
                    'lat' => $latitude,
                    'lon' => $longitude
                ]
            ],
        ];
        return $this->_daoSearch->addPark($addInfoList);
    }
}