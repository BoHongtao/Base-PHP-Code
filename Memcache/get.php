<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/8/5
 * Time: 19:03
 */
$mem = new Memcache();
$mem -> connect('localhost',11211);
echo $mem->get('name');