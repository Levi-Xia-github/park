<?php


namespace app\controller;


use app\Base\BaseAction;
use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Service\Blog\BlogService;

class AddBlog extends BaseAction
{
    protected  $_checkLogin = true;
    protected  $_needLogin = true;

    public function index()
    {
        $_serviceUser = new BlogService();

        $userId = $this->_userId;
        $title = $this->_getInput('title','');
        $content = $this->_getInput('content','');
        $tag = $this->_getInput('tag','');
        $picList = $this->_getInput('picList','');
        $longitude = $this->_getInput('longitude','');
        $latitude = $this->_getInput('latitude','');

        if(empty($title) || empty($content)){
            throw new BaseException(BaseErrorCode::PARAM_ERROR);
        }
        $ret = $_serviceUser->addBlog($title,$content,$userId,$tag,$picList,$longitude,$latitude);

        return $this->success($ret);
    }
}