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
    //生成验证码
    public function captcha(){
        $captcha = new \Captcha();
        $captcha->generate();
    }
    
    public function check(){
        //获取用户输入
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $captcha  = trim($_POST['captche']);
        //验证数据合法性
        if(empty($captcha) || empty($password) ||empty($username) ){
            //数据为空，重新输入
            $this->error('username or password is empty','p=back&m=previlege');
        }
        //验证码是否正确
        if(!\Captcha::checkCaptcha($captcha)){
            $this->error('captche is wrong', 'p=back&m=previlege');
        }
        $admin = new \Model\Admin();
        $user = $admin->CheckUser($username,$password);
        if(!$user){
            $this->error('username or password is wrong','p=back&m=Privilege');
        }
        //成功
        $_SESSION['user'] = $user;
        $this->success('welcome'.$username.'login in','p=back');
        
    }
}