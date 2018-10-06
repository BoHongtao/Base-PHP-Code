<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/8/5
 * Time: 19:54
 */
$mem = new Memcache();
$mem ->addServer('localhost','8888');
$mem ->addServer('localhost','9999');
$mem->set('name','xiaolanzi',0,10);