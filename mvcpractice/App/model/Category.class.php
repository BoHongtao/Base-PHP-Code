<?php
namespace Model;

use Core\Model;

class Category extends Model{
    protected $table = "bl_category";
    public function getAll(){
        $sql = "select * from $this->table";
        $categories =  $this->dao->db_getAll($sql);
        return $this->nolimit($categories);
    }
    //查找同一父类下是否有相同类名
    public function checkCategoryName($parent_id,$name){
        $parent_id = addslashes($parent_id);
        $name = addslashes($name);
        $sql = "select id from $this->table where c_parent_id = $parent_id and c_name = $name";
        return $this->dao->db_getOne($sql);
    }
    public function insert($name,$parent_id,$sort){
        $sql = "insert into $this->table values(null,$name,$parent_id,$sort)";
        return $this->dao->db_exec($sql);
    }
    
    public function nolimit($categories,$parent_id=0,$level=0){
        
        static $list = array();
        foreach($categories as $cat){
            if($cat['c_parent_id'] == $parent_id){
                $cat['level'] = $level;
                $list[] = $cat;
                $this->nolimit($categories,$cat['id'],$level+1);
            }
        }
    return $list;
    }
    public function delete($id){
        $sql = "delete from {$this->table} where id = {$id}";
        return $this->dao->db_exec($sql);
    }
    public function getOne($id){
        $sql = "select * from {$this->table} where id = {$id}";
        return $this->dao->db_getOne($sql);
    }
}