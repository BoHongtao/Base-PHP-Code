<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017/3/18
 * Time: 15:46
 */
    //删除Cookie文件和$_COOKIE数组
    //1、删除指定的cookie
    //删除文件
    setcookie('username','',time()-1);
    //删除服务器已经读到的cookie,就是数组中的
    if(isset($_COOKIE['username'])){
        unset($_COOKIE['username']);
    }
    //2、删除所有的cookie(本网站)
    foreach ($_COOKIE as $key=>$val){
        setcookie('$key','',time()-1);
    }
    unset($_COOKIE);