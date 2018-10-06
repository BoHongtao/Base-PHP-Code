<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/8/6
 * Time: 15:56
 */
namespace Home\Controller;



use Think\Controller;

class RedisController extends Controller
{
    public function add()
    {
    S(array(
        'type'=>'redis',
        'host'=>'192.168.11.49',
        'port'=>'6379'
    ));
    S('name','xiaoming',180);
    echo 'ok';
    }
    public function get()
    {
        S(array(
            'type'=>'redis',
            'host'=>'192.168.11.49',
            'port'=>'6379'
        ));
        var_dump(S('name'));
    }
}