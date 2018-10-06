<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/8/5
 * Time: 10:46
 */
$mem = new Memcache();
$mem -> connect('localhost',11211);
//设置数据
$mem ->add('name','xiaomin',MEMCACHE_COMPRESSED,time()+60);
//$mem ->replace('name','xiao',MEMCACHE_COMPRESSED,60);
//echo $mem->get('name');
//$mem ->set('age','20',0,60);
//$mem ->decrement('age',1);
//echo "<br/>";
//echo $mem->get('age');
//$mem->flush();
//$mem->close();
