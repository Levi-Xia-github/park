<?php


namespace app\Service\Blog;


use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Base\BaseService;
use app\Dao\Blog\BlogDao;

class BlogService extends BaseService
{
    public $_daoBlog = Null;

    public function __construct()
    {
        $this->_daoBlog = new BlogDao();
    }

    public function addBlog($title,$content,$userId,$tag='',$picList='',$longitude='',$latitude=''){
        if(empty($title) || empty($content)){
            throw new BaseException(BaseErrorCode::PARAM_ERROR);
        }
        $blogInfo = [
            'title' => $title,
            'content' => $content,
            'userId' => $userId,
            'createTime' => time(),
            'updateTime' => time(),
        ];
        !empty($tag) && $blogInfo['tag'] = $tag;
        !empty($picList) && $blogInfo['picList'] = $picList;
        !empty($longitude) && $blogInfo['longitude'] = $longitude;
        !empty($latitude) && $blogInfo['latitude'] = $latitude;
        $ret =  $this->_daoBlog->addBlog($blogInfo);
        return $ret;
    }

    public function getBlog($blogId){

    }

    public function getBlogByUserId($userId){

    }

    public function getBlogByAuditSts($auditSts,$sortId,$num){
        if(empty($auditSts) || !in_array($auditSts,['HOT','PASS','NOPASS','BAN'])){
            throw new BaseException(BaseErrorCode::PARAM_ERROR);
        }
        if(empty($num)){
            return [];
        }
        $blogListRet = $this->_daoBlog->getBlogByAuditSts($auditSts,$sortId,$num);
        $ret = $this->buildBlogDetails($blogListRet);
        return $ret;
    }

    public function updateBlog($blogId,$updateBlogInfo){

    }

    public function buildBlogDetails($blogList){
        if(empty($blogList)){
            return [];
        }
        //build点赞量，浏览量，评论量

        return $blogList;
    }





}