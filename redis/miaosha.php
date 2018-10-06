<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/8/6
 * Time: 18:41
 */
$stroe = 3;
$redis = new Redis();
//连接reids服务器
$result = $redis->connect('192.168.11.49',6379);
//密码（如果在TP框架中使用密码的话需要修改TP代码）
$redis->auth('jinan');
//商品数量
$goods_number = 3;
//初始化链表，头节点添加节点
for($i = 0 ; $i < $goods_number ;++$i){
    $redis->lPush('goods_store',1);
}
//抢购的时间5s
$redis->setTimeout('goods_store',5);
//输出链表长度
echo $redis->lLen('goods_store');
?>