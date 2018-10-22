<?php
/*
 * �����ǿ������Ļ��࣬��ŵ��ǿ����������Ĵ���
 */
    namespace Core;
    class Controller{
        public $smarty;
        //��ʼ��smarty
        public function __construct(){
            include_once VENDOR_DIR . 'Smarty/Smarty.class.php';
            $this->smarty = new \Smarty();
            $this->smarty->setTemplateDir(APP_DIR.PLAT.'/View/'.MODULE.'/');
            $this->smarty->setCompileDir(APP_DIR.PLAT.'/View_c/');
        }
        
		//��������
		protected function success($msg,$url,$time = 1){
			//��ת��ʾ����
			header("Refresh:{$time};url='index.php?{$url}'");
			echo $msg;
			//��ֹ�ű�
			exit();
		}

		protected function error($msg,$url,$time = 3){
			//��ת��ʾ����
			header("Refresh:{$time};url='index.php?{$url}'");
			echo $msg;
			//��ֹ�ű�
			exit();
		}
	}