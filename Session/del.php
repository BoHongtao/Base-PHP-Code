<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017/3/19
 * Time: 16:32
 */
    session_start();
    //删除一个
    if(isset($_SESSION['name'])){
        unset($_SESSION['name']);
    }
    //删除多个
    foreach ($_SESSION as $key =>$val){
        unset($_SESSION[$key]);
    }
    //删除所有包括文件
    foreach ($_SESSION as $key1=>$value){
        unset($_SESSION[$key1]);
    }
    session_destroy();