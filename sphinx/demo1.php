<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/8/11
 * Time: 11:07
 */
header("Content-type:text/html;charset=utf8");
require_once "sphinxapi.php";
//创建一个对象
$sc = new SphinxClient();
//连接服务器
$sc->setServer('localhost','9312');


//显示查询的数量
//$sc->setLimits(0,10);
//查询
//查询关键字
$keywords = '司';
//使用的索引
$indexname = 'address';
//设置匹配模式
$sc->setMatchMode(SPH_MATCH_PHRASE);
$res = $sc->query($keywords,$indexname);
//echo "<pre>";
//var_dump($res);die;
$ids = $res['matches'];
$id = implode(',',array_keys($ids));
//var_dump($id);die;

//连接数据库
$conn = @mysql_connect('localhost','root','root');
mysql_query('use php');
mysql_query('set names utf8');

$result = mysql_query("select id,comname,comaddress from address where id in($id)");

$data = array();
$count = 0;
while($row = mysql_fetch_assoc($result)){
    $data[] = $row;
    $count++;
}
foreach ($data as $v){
    //显示结果

    echo $v['comname'].'<br/>'.$v['comaddress'].'<hr>';

    //高亮显示关键词
//    $v = $sc->buildExcerpts($v,$indexname,$keywords,array(
//        'before_match'=>'<font style="color:#f00">',
//        'after_match'=>'</font>'
//    ));
//    echo $v[1].'<br/>'.$v[2].'<hr>';
}
echo "共".$count."个结果";