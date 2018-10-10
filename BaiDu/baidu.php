<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/6/29
 * Time: 12:40
 */


header('Content-type:text/html;charset=utf-8');
$keyword = $_POST['keyword'];


$pdo = new PDO('mysql:host=localhost;dbname=blog','root','root');

$sql = "select a_name from bl_article where a_name like '$keyword%' limit 10";

$stmt = $pdo->query($sql);

$count = $stmt->rowCount();

$data = array();
for($i=0;$i<$count;++$i){
    $data[] = $stmt->fetch(PDO::FETCH_ASSOC);
}
//var_dump($data);die();
//如果查询数据为空，die
if(count($data) == 0) {
   $data[] = 0;
}
echo json_encode($data);

