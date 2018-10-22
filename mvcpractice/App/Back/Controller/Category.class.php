<?php
namespace Back\Controller;

use Core\Controller;


class Category extends Controller{
    protected $category;
    
    public function __construct(){
        parent::__construct();
       $this->category = new \Model\Category();
    }
    
    //��ȡ�б�
    public function index(){
        //��ȡ�б�����
        $categories = $this->category->getAll();
        //��������
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
     //��֤���ݺϷ���
     if(empty($name)){
         $this->error('name is empty','p=Back&m=Category&a=add');
     }
     if(!is_numeric($sort) || $sort!=(integer)$sort || $sort <0){
         $this->error('sort is not a numner or < 0','p=Back&m=Category&a=add');
     }
     //���Ҹ������Ƿ�����ͬ������
     if($this->category->checkCategoryName($parent_id,$name)){
         $this->error('name is already exist','p=Back&m=Category&a=add');
     }
     
      //���
     if($this->category->insert($name, $parent_id, $sort)){
         $this->success("success", 'p=Back&m=Category');
     }else{
         $this->error('fail','p=Back&m=Category');
     }    
    }
    //ɾ��
    public function delete(){
        $id = $_REQUEST['id'];
        if(!$this->category->delete($id)){
            $this->error("delete date fail",'p=Back&m=category');
         }else{
            $this->success("delete date success",'p=Back&m=category');
         }
    }
    //��ʾ�༭����
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
        //��������
        $name = trim($_POST['name']);
        $parent_id = (integer)$_POST['parent_id'];
        $sort = trim($_POST['sort']);
        //�Ϸ����ж�
        if(empty($name)) $this->error('�������ֲ���Ϊ�գ�','p=back&m=category&a=edit&id=' . $id);
        if(!is_numeric($sort) || $sort != (integer)$sort || $sort < 0){
            $this->error('�������Ϊ��������','p=back&m=category&a=edit&id=' . $id);
        }
        //�ж�ͬһ�����²�������ͬ������
        $category = new \Model\Category();
        $cat = $category->checkCategoryName($parent_id,$name);
        //�ų��Լ�
        if($cat && $cat['id'] != $id){ 
            //��ǰ����������ͬ�����࣬�ҷ��໹�ǵ�ǰҪ�༭�ķ���
            $this->error('��ǰ�������֣�' . $name . '�Ѿ����ڣ�','p=back&m=category&a=edit&id=' . $id);
        }
        //���²���
        if($category->updateCategory($id,$name,$parent_id,$sort)){
            $this->success('���³ɹ���','p=back&m=category');
        }else{
            //ʧ��
            $this->error('����ʧ�ܣ�','p=back&m=category&a=edit&id=' . $id);
        }
    }
}