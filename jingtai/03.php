<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/7/28
 * Time: 11:42
 */

ob_start();
echo 1;
ob_get_clean();

ob_start();
echo 2;
echo ob_get_contents();
