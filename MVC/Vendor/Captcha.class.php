<?php
/*
 * ��֤����
 */
class Captcha{
		//���ԣ�������֤��ͼƬ��������
		private $width;
		private $height;
		private $length;
		private $font;		//����
		private $dots;
		private $lines;

		public function __construct($arr = array()){
			$this->width = isset($arr['width']) ? $arr['width'] : 200;
			$this->height = isset($arr['height']) ? $arr['height'] : 40;
			$this->length = isset($arr['length']) ? $arr['length'] : 4;
			$this->font = isset($arr['font']) ? $arr['font'] : './Fonts/impact.ttf';
			$this->dots = isset($arr['dots']) ? $arr['dots'] : 100;
			$this->lines = isset($arr['lines']) ? $arr['lines'] : 10;
		}

		//������֤��ͼƬ
		public function generate(){
			//��������
			$img = imagecreatetruecolor($this->width,$this->height);
			//����ɫ
			$bg_c = imagecolorallocate($img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
			imagefill($img,0,0,$bg_c);

			//���ݣ����ź;����ַ�
			//���ŵ㣺*����
			for($i = 0;$i < $this->dots;$i++){
				$dots_c = imagecolorallocate($img,mt_rand(150,200),mt_rand(150,200),mt_rand(150,200));
				imagestring($img,mt_rand(1,5),mt_rand(0,$this->width),mt_rand(0,$this->height),'*',$dots_c);
			}

			//������
			for($i = 0;$i < $this->lines;$i++){
				$lines_c = imagecolorallocate($img,mt_rand(100,150),mt_rand(100,150),mt_rand(100,150));
				imageline($img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$lines_c);
			}

			//��������
			$string_arr = array_merge(range(1,9),range('a','z'),range('A','Z'));
			$captcha = '';
			for($i = 0;$i < $this->length;$i++){
				//����˳��
				shuffle($string_arr);

				//��������
				$captcha .= $string_arr[0];

				//д��
				$str_c = imagecolorallocate($img,mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));
				$ceil = ceil($this->width / ($this->length + 1));
				imagettftext($img,mt_rand(10,20),mt_rand(-45,45),$ceil * ($i + 1),mt_rand(20,30),$str_c,$this->font,$string_arr[0]);
			}

			//���ַ������ݱ��浽session
			@session_start();
			$_SESSION['captcha'] = $captcha;

			//�������
			header('Content-type:image/png');
			imagepng($img);

			//������Դ
			imagedestroy($img);
		}

		//��֤��֤�룺�û��ύ����session�б���Ľ��жԱ�
		public static function checkCaptcha($captcha){
			//$captcha���û��ύ����֤�����ݣ���֤��ʱ�����ִ�Сд
			@session_start();
			return strtolower($captcha) === strtolower($_SESSION['captcha']);
		}

	}

