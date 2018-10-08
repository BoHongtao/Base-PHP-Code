<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/8/11
 * Time: 11:40
 */

header("Content-type:text/html;charset=utf8");

$conn = @mysql_connect('localhost','root','root');
mysql_query('use php');
mysql_query('set names utf8');

$result = mysql_query("select id,comname,comaddress from address where comname LIKE '%公司%'");

$data = array();
$count = 0;
while($row = mysql_fetch_assoc($result)){
    $data[] = $row;
    $count++;
}
foreach ($data as $v) {
    echo $v['comname'].'<br/>'.$v['comaddress'].'<hr>';
}

echo "共".$count."个结果";