<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/8/6
 * Time: 18:46
 */
$redis=new Redis();
$redis->connect('192.168.11.49',6379);
$redis->auth('jinan');
//如果运行这个php文件，就把链表中的尾节点删除。
//lpop的返回值是链表的头元素，当链表为空的时候，返回null
$count=$redis->lpop('goods_store');
if(!$count){
    echo '抢购失败';
}else{
    echo '抢购成功';
}