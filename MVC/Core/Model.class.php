<?php
/*  公共模型
 * 这个是模型的基类，很多的模型都有相同的操作
 * 我们把重复的代码放在基类中
 */
namespace Core;

class Model{
    //保存DAO对象
    protected $dao;
    public function __construct(){
        //连接数据库
        $this->dao = new MyPDO();
    }
}