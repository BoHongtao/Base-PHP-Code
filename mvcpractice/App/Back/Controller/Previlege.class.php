<?php
namespace Back\Controller;
use Core\Controller;

class previlege extends Controller{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->smarty->display('login.html');
    }
    //������֤��
    public function captcha(){
        $captcha = new \Captcha();
        $captcha->generate();
    }
    
    public function check(){
        //��ȡ�û�����
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $captcha  = trim($_POST['captche']);
        //��֤���ݺϷ���
        if(empty($captcha) || empty($password) ||empty($username) ){
            //����Ϊ�գ���������
            $this->error('username or password is empty','p=back&m=previlege');
        }
        //��֤���Ƿ���ȷ
        if(!\Captcha::checkCaptcha($captcha)){
            $this->error('captche is wrong', 'p=back&m=previlege');
        }
        $admin = new \Model\Admin();
        $user = $admin->CheckUser($username,$password);
        if(!$user){
            $this->error('username or password is wrong','p=back&m=Privilege');
        }
        //�ɹ�
        $_SESSION['user'] = $user;
        $this->success('welcome'.$username.'login in','p=back');
        
    }
}