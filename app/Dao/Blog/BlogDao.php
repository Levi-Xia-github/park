<?php


namespace app\Dao\Blog;

use app\Base\BaseDao;

class BlogDao extends BaseDao
{
    public $_cluster = 'park';
    public $_tbl = 'park_blog';
    public $_pkey = 'blogId';

    public $fields = ['blogId','title','content','userId','tag','like','browse','picList','longitude','latitude','auditSts','createTime','updateTime'];

    public function addBlog($blogInfo){
        $ret = $this->insert($blogInfo);
        return $ret;
    }

    public function getBlogByAuditSts($auditSts,$sortId,$num){
        $limit = [0,$num];
        $conds = [
            ['auditSts','=',$auditSts],
        ];
        !empty($sortId) && $conds[] = ['blogId','<',$sortId];
        $order = ['blogId' => 'desc'];
        $ret = $this->select($this->fields,$conds,$limit,$order);
        return $ret;
    }
}