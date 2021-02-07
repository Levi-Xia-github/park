<?php


namespace app\Dao;


use app\Base\BaseDao;

class UserDao extends BaseDao
{
    public $_cluster = 'park';
    public $_tbl = 'park_user';
    public $_pkey = 'id';


}