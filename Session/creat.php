<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017/3/19
 * Time: 16:23
 */

    //1、启用session机制
    session_start();
    //2、创建session
    $_SESSION['name'] = 'dddd';
    echo '创建Session成功';
