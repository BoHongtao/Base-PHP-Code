<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/8/6
 * Time: 14:44
 */
$redis = new Redis();
$redis->connect('192.168.11.49',6379);
$redis->auth('jinan');

$redis->set('username','xiaoli');
echo $redis->get('username');