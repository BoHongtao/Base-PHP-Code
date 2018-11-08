<?php

namespace Home\Controller;

use Core\Controller;

//发出命令去调用模型、调用视图
class Index extends Controller{
    //入口方法
    public function index(){
        echo "welcome to use mvc<br/>";
    }
}