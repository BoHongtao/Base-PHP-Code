<?php
    //生成一个静态文件
    $city = "北京";
    $weather = "sunshine";
    $banji = "php0101";
    $kemu = "静态化技术";
    ob_start(); //开启php缓冲区
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>新建网页</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h2>静态</h2>
<?php ob_clean(); ?>
<p>城市：<?php echo $city; ?></p><p>天气：<?php echo $weather; ?></p>
<p>班级：<?php echo $banji; ?></p><p>科目：<?php echo $kemu; ?></p>
</body>
</html>

<?php
$count = ob_get_contents();  //收集php缓冲区内的内容
file_put_contents('./ob.html',$count);
?>