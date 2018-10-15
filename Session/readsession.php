<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017/3/24
 * Time: 15:24
 */
    session_start();
    $_SESSION['name'] = isset($_SESSION['name'])?$_SESSION['name']:'';
    echo $_SESSION['name'];


echo "<script>window.location.href='../index.php'</script>";