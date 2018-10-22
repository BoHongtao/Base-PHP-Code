<?php
/*
 * 这里是控制器的基类，存放的是控制器公共的代码
 */
    namespace Core;
    class Controller{
        public $smarty;
        //初始化smarty
        public function __construct(){
            include_once VENDOR_DIR . 'Smarty/Smarty.class.php';
            $this->smarty = new \Smarty();
            $this->smarty->setTemplateDir(APP_DIR.PLAT.'/View/'.MODULE.'/');
            $this->smarty->setCompileDir(APP_DIR.PLAT.'/View_c/');
        }
        
		//公共方法
		protected function success($msg,$url,$time = 1){
			//跳转提示功能
			header("Refresh:{$time};url='index.php?{$url}'");
			echo $msg;
			//终止脚本
			exit();
		}

		protected function error($msg,$url,$time = 3){
			//跳转提示功能
			header("Refresh:{$time};url='index.php?{$url}'");
			echo $msg;
			//终止脚本
			exit();
		}
	}