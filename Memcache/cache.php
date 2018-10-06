<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/8/5
 * Time: 19:10
 */

$mem = new Memcache();
$mem->connect('127.0.0.1','11211');
$sql = "select * from `product`";
$key = md5($sql);
$data = $mem->get($key);
if(!$data){
    echo "我连接数据库啦啦啦啦啦";
    @mysql_connect('127.0.0.1','root','root');
    @mysql_query('use test');
    @mysql_query('set names utf8');
    @$res = mysql_query($sql);
    $data = array();
    while($row = @mysql_fetch_assoc($res)){
        $data[] = $row;
    }
    $mem->set($key,$data,0,'30');
}
    var_dump($data);