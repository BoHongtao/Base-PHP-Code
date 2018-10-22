<?php

	//��ʼ���ļ�
	//�����ռ�
	namespace Core;
	//Ȩ���ж�
	if(!defined('ACCESS')) header('Location:../index.php');

	//������
	class App{
		//2.��ʼ���ַ���
		private static function initCharset(){
			header('Content-type:text/html;charset=utf-8');
		}

		//3.����Ŀ¼����
		private static function initDirConst(){
			//echo __DIR__;	//__DIR__�Ƕ�̬��ȡ�ģ�������windows��ȡ��Ŀ¼�ָ����Ƿ�б�ܣ�
			//����滻����б��
			define('ROOT_DIR', str_replace('Core','',str_replace('\\','/',__DIR__)));
			//��Ȼ�������Ŀ¼����ô��Ӧ����Ŀ¼��β����"/"
			define('CORE_DIR',ROOT_DIR . 'Core/');
			define('APP_DIR',ROOT_DIR . 'App/');
			define('CONFIG_DIR',ROOT_DIR . 'Config/');
			define('PUBLIC_DIR',ROOT_DIR . 'Public/');
			define('UPLOAD_DIR',ROOT_DIR . 'Upload/');
			define('VENDOR_DIR',ROOT_DIR . 'Vendor/');
		}

		//4.�趨ϵͳ����
		private static function initSystem(){
			@ini_set('error_reporting',E_ALL);	//���󼶱����
			@ini_set('display_errors',1);		//�Ƿ���ʾ����
		}

		//5.�趨�����ļ�
		private static function initConfig(){
			//ȫ�ֻ������ļ�
			global $config;
			//���������ļ�����ConfigĿ¼��
			$config = include_once CONFIG_DIR . 'config.php';
			
		}

		//6.��ʼ��URL����URL�л�ȡ�������ݣ�ƽ̨��������������
		//http://www.icframe.com/index.php?p=Home&m=������&a=������
		private static function initURL(){
			//��ȡ��������
			$plat   = isset($_REQUEST['p']) ? $_REQUEST['p'] : 'Home';
			$module = isset($_REQUEST['m']) ? $_REQUEST['m'] : 'Index';
			$action = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index';

			//�⼸�����ݻ�ʹ�ñȽ϶ࣺȫ�ֻ�ÿ�ζ���Ҫ����Ƚ��鷳�����峣��
			define('PLAT',$plat);
			define('MODULE',$module);
			define('ACTION',$action);
		}

		//7.�趨�Զ�����
		private static function initAutoload(){
			//���û��Զ���ķ���ע�ᵽ�Զ����ػ����У�ע���ʱ���������õ�������ע��
			spl_autoload_register(array(__CLASS__,'loadCore'));	
			spl_autoload_register(array(__CLASS__,'loadController'));	
			spl_autoload_register(array(__CLASS__,'loadModel'));	
			spl_autoload_register(array(__CLASS__,'loadVendor'));	
		}
		
		//���Ӷ�����������ز�ͬ�ļ��е���
		//���غ�����
		private static function loadCore($clsname){
			//����ļ�
			$file = CORE_DIR . basename($clsname) . '.class.php';
			if(is_file($file)){
				include_once $file;
			}
		}
		//����Vendor
		private static function loadVendor($clsname){
			//����ļ�
			$file = VENDOR_DIR . basename($clsname) . '.class.php';
			if(is_file($file)){
				include_once $file;
			}
		}

		private static function loadController($clsname){
			//����ļ�
			$file = APP_DIR . PLAT .'/Controller/'. basename($clsname) . '.class.php';
			if(is_file($file)){
				include_once $file;
			}
		}

		private static function loadModel($clsname){
			//����ļ�
			$file = APP_DIR . 'Model/' . basename($clsname) . '.class.php';
			if(is_file($file)){
				include_once $file;
			}
		}
  		//8.�ַ�������
		private static function initDispatch(){
			$action = ACTION;
			$module = "\\" . PLAT . "\\Controller\\" . MODULE;
			$m = new $module();
			$m->$action();			
		}

		public static function run(){
			//���ظ���Ҫ��ʼ���Ĺ��ܷ���
			//��ʼ���ַ���
			self::initCharset();
			//����Ŀ¼����
			self::initDirConst();
			//�趨ϵͳ����
			self::initSystem();
			//�趨�����ļ�
			self::initConfig();
			//��ʼ��URL
			self::initURL();
			//�趨�Զ�����
			self::initAutoload();	//˼�����Ƿ���Էŵ�initURL����֮ǰ
			//�ַ�������
			self::initDispatch();
		}
	}