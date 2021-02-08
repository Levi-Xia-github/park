<?php


namespace app\controller;


use app\Base\BaseAction;
use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Service\Blog\BlogService;

class BlogHome extends BaseAction
{
    protected  $_checkLogin = true;
    protected  $_needLogin = true;

    public function index()
    {
        $_serviceUser = new BlogService();
        $hotSortId = $this->_getInput('hotSortId',0);
        $passSortId = $this->_getInput('passSortId',0);
        $noPassSortId = $this->_getInput('noPassSortId',0);

        $isEnd = $this->_getInput('isEnd',true);
        if(empty($isEnd)){
            throw new BaseException(BaseErrorCode::PARAM_ERROR);
        }

        $allNum = 20;
        $hotNum = 10;
        $passNum = 5;
        $noPassNum = 5;
        $blogList = [];

        $output = [
            'isEnd' => true,
            'hotSortId' => 0,
            'passSortId' => 0,
            'noPassSortId' => 0,
            'blogList' => [],
        ];
        if($isEnd == false || $isEnd == 'false'){

            $hotBlogList = $_serviceUser->getBlogByAuditSts('HOT',$hotSortId,$hotNum);
            $blogList = array_merge($blogList,$hotBlogList);
            $output['hotSortId'] = empty($hotBlogList) ? 0 : end($hotBlogList)['blogId'];
            $output['blogList'] = $blogList;

            if(count($hotBlogList) < $hotNum){
                $passNum = $allNum - count($hotBlogList);
            }

            $passBlogList = $_serviceUser->getBlogByAuditSts('PASS',$passSortId,$passNum);
            $blogList = array_merge($blogList,$passBlogList);
            $output['passSortId'] = empty($passBlogList) ? 0 : end($passBlogList)['blogId'];
            $output['blogList'] = $blogList;

            if(count($passBlogList) < $passNum){
                $noPassNum = $allNum - count($hotBlogList) - count($passBlogList);
            }

            $noPassBlogList = $_serviceUser->getBlogByAuditSts('NOPASS',$noPassSortId,$noPassNum);
            $blogList = array_merge($blogList,$noPassBlogList);
            $output['noPassSortId'] = empty($noPassBlogList) ? 0 : end($noPassBlogList)['blogId'];
            $output['blogList'] = $blogList;

            $output['isEnd'] = count($hotBlogList) + count($passBlogList) + count($noPassBlogList) < $allNum ? true : false;
        }
        return $this->success($output);
    }

}