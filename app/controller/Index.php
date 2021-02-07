<?php
namespace app\controller;

use think\facade\Config;


class Index extends  BaseAction
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V' . \think\facade\App::version() . '<br/><span style="font-size:30px;">14载初心不改 - 你值得信赖的PHP框架</span></p><span style="font-size:25px;">[ V6.0 版本由 <a href="https://www.yisu.com/" target="yisu">亿速云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ee9b1aa918103c4fc"></think>';
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }

    public function config(){
//        return Env::get('database.hostname');
        return Config::get('database.connections.mysql.hostname');
    }

    public function array(){
        $arr =[1,3,4,6];
        return json($arr);
    }

    public function test(){
        $id = $this->getInput('id',123);
        $name = $this->getInput('name','');
        return $id  . "/" . $name;
    }

    public function view(){
        $arr = [
            'name' => 123,
            'id' => 888,
        ];
        return $this->buildOutput('view',$arr);
    }

    public function output()
    {
        return $this->success(11);
    }
}