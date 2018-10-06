<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/7/28
 * Time: 9:48
 */
ob_start();

//echo str_repeat('&nbsp;',5000);
//echo "<br>";
for($i = 0 ; $i < 5 ; ++$i)
{
    sleep(1);
    echo $i."<br>";
    ob_flush();
    flush();
}