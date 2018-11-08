<?php

	//�ļ��ϴ��ࣨͼƬ��

	class Upload{
		//��̬���Ա���MIME����
		private static $image_type = array('image/jpeg','image/jpg','image/gif','image/png');

		//��¼������Ϣ
		public static $error = '';

		/*
		 * �ļ��ϴ�
		 * @param1 array $file���ϴ����ļ���Ϣ��5��Ҫ�أ�
		 * @param2 string $path���ϴ�·��
		 * @return string $new_name���ļ������������֣��ļ��ϴ������������
		 */
		 public static function uploadImage($file,$path){
			//�ж�
			if(!is_array($file) || !isset($file['error'])){
				//�����ϴ��ļ�����
				self::$error = '���������';
				return false;
			}

			//�ļ������ж�
			if(!in_array($file['type'],self::$image_type)){
				self::$error = '��ǰ�ļ������Ͳ�����';
				return false;
			}

			//�ж��ļ��Ƿ��ϴ��ɹ�
			switch($file['error']){
				case 1:
					self::$error = '�ļ�����';
					return false;
				case 2:
					self::$error = '�ļ�����';
					return false;
				case 3:
					self::$error = '�ļ��ϴ����ֳɹ���';
					return false;
				case 4:
					self::$error = 'û��ѡ���ļ���';
					return false;
				case 6:
					self::$error = '��ʱ�ļ��в����ڣ�';
					return false;
				case 7:
					self::$error = '�ļ��ϴ�ʧ�ܣ�';
					return false;
			}

			//��ȡ�ļ������֣�����.��׺
			$new_name = self::getNewName($file['name']);

			//ת�ƴ洢
			if(move_uploaded_file($file['tmp_name'],$path . '/' . $new_name)){
				//�ɹ�
				return $new_name;
			}else{
				//ʧ��
				self::$error = '�ļ��ϴ���ָ���ļ���ʧ�ܣ�';
				return false;
			}
		 }


		 //��ȡ������
		 private static function getNewName($filename){
			//���ֹ���YYYYMMDDHHIISSXXX.��׺��
			$newname = date('YmdHis');

			//ȡ���������
			$arr = array_merge(range('a','z'),range('A','Z'));
			shuffle($arr);
			$newname .= $arr[0] . $arr[1] . $arr[2] . $arr[3];

			//�����׺
			$newname .= '.' . strrchr($filename,'.');

			//����
			return $newname;
		 }
	}