<?php
namespace Model;
use Core\Model;

class Admin extends Model{
    protected $table = 'admin';
    public function CheckUser($username,$password){
        $username = addslashes($username);
        $password = md5($password);
        $sql = "select * from `bl_admin` where a_username='{$username}' and a_password = '{$password}'";
        //Ö´ÐÐ
        return $this->dao->db_getOne($sql);
    }
}