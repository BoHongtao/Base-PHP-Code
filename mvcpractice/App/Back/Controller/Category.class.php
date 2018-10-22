<?php
namespace Back\Controller;

use Core\Controller;


class Category extends Controller{
    protected $category;
    
    public function __construct(){
        parent::__construct();
       $this->category = new \Model\Category();
    }
    
    //获取列表
    public function index(){
        //获取列表结果集
        $categories = $this->category->getAll();
        //分配数据
        $this->smarty->assign('categories',$categories);
        $this->smarty->display('categoryIndex.html');
    }
    public function add(){
        $categories = $this->category->getAll();
        $this->smarty->assign('categories',$categories);
        $this->smarty->display('categoryAdd.html');
    }
    
    
    public function insert(){
     $name = trim($_POST['name']);
     $parent_id = trim($_POST['parent_id']);
     $sort = trim($_POST['sort']);
     //验证数据合法性
     if(empty($name)){
         $this->error('name is empty','p=Back&m=Category&a=add');
     }
     if(!is_numeric($sort) || $sort!=(integer)$sort || $sort <0){
         $this->error('sort is not a numner or < 0','p=Back&m=Category&a=add');
     }
     //查找父类下是否有相同的类名
     if($this->category->checkCategoryName($parent_id,$name)){
         $this->error('name is already exist','p=Back&m=Category&a=add');
     }
     
      //入库
     if($this->category->insert($name, $parent_id, $sort)){
         $this->success("success", 'p=Back&m=Category');
     }else{
         $this->error('fail','p=Back&m=Category');
     }    
    }
    //删除
    public function delete(){
        $id = $_REQUEST['id'];
        if(!$this->category->delete($id)){
            $this->error("delete date fail",'p=Back&m=category');
         }else{
            $this->success("delete date success",'p=Back&m=category');
         }
    }
    //显示编辑界面
    public function edit(){
        $id = $_REQUEST['id'];
        $categories = $this->category->getAll();
        $edit = $this->category->getOne($id);
        $this->smarty->assign('edit',$edit);
        $this->smarty->assign('categories',$categories);
        $this->smarty->display('categoryEdit.html');
    }
    public function update(){
        $id = (integer)$_REQUEST['id'];
        //接收数据
        $name = trim($_POST['name']);
        $parent_id = (integer)$_POST['parent_id'];
        $sort = trim($_POST['sort']);
        //合法性判定
        if(empty($name)) $this->error('分类名字不能为空！','p=back&m=category&a=edit&id=' . $id);
        if(!is_numeric($sort) || $sort != (integer)$sort || $sort < 0){
            $this->error('排序必须为正整数！','p=back&m=category&a=edit&id=' . $id);
        }
        //判断同一父类下不能有相同的类名
        $category = new \Model\Category();
        $cat = $category->checkCategoryName($parent_id,$name);
        //排除自己
        if($cat && $cat['id'] != $id){ 
            //当前父分类下有同名分类，且分类还是当前要编辑的分类
            $this->error('当前分类名字：' . $name . '已经存在！','p=back&m=category&a=edit&id=' . $id);
        }
        //更新操作
        if($category->updateCategory($id,$name,$parent_id,$sort)){
            $this->success('更新成功！','p=back&m=category');
        }else{
            //失败
            $this->error('更新失败！','p=back&m=category&a=edit&id=' . $id);
        }
    }
}