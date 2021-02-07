<?php

namespace  app\controller;

class Test extends  BaseAction {

    public function index(){
        return 'method name : '.$this->request->action();
    }

    public function getPath(){
        return "path ".$this->app->getAppPath();
    }
}