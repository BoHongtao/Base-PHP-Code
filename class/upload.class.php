<?php

	/**
	* 上传类
	*/
    class Upload{

		private $_upload_path = '../Uploadfile/';
		private $_upload_max_size = 1*1024*1024;
		private $_prefix = 'John_';
		private $_ext_allow_list = array('.png','.jpg','.gif');
		private $_mime_allow_list = array('image/png', 'image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png');

        //get和set方法
        public function getUploadPath()
        {
            return $this->_upload_path;
        }
        public function getUploadMaxSize()
        {
            return $this->_upload_max_size;
        }
         public function getPrefix()
        {
            return $this->_prefix;
        }
        public function getExtAllowList()
        {
            return $this->_ext_allow_list;
        }
        public function getMimeAllowList()
        {
            return $this->mime_allow_list;
        }



        public function setUploadPath($upload_path)
        {
            $this->_upload_path = $upload_path;
        }

        public function setMimeAllowList($mime_allow_list)
        {
            $this->mime_allow_list = $mime_allow_list;
        }
        public function setUploadMaxSize($upload_max_size)
        {
            $this->_upload_max_size = $upload_max_size;
        }

        public function setPrefix($prefix)
        {
            $this->_prefix = $prefix;
        }

        public function setExtAllowList($ext_allow_list)
        {
            $this->_ext_allow_list = $ext_allow_list;
        }

        public function doUpload($file_info)
        {
            //获取上传文件的名字
            $upload_filename = $file_info['name'];
            echo "上传文件的名字";
            var_dump($upload_filename);
            //1.判断文件是传入
            if($file_info['error'] != 0){
                echo '<br>上传文件有误';
                return false;
            }
            //2.判断文件过大(还要修改php.ini->upload_max_filesize)
        
            if($file_info['size'] > $this->_upload_max_size){
                echo '<br>.文件过大';
                return false;
            }
        
            //3.防覆盖-->转换成唯一文件名uniqid
           
            //获取后缀
            $ext = strtolower(strrchr($upload_filename,'.'));
            $upload_filename = uniqid($this->_prefix,true);
            $upload_filename = $upload_filename.$ext;
            //echo $upload_filename;
            //4.每天上传的都放不同的文件夹
            $sub_dir = date('Ymd').'/';
            //var_dump($sub_dir);string(9) "20170407/"每天生成的文件夹的名称
            if(!is_dir($this->_upload_path.$sub_dir)){
                //目录不存在创建目录
                mkdir($this->_upload_path.$sub_dir);
                echo "这是路径";
                var_dump($this->_upload_path.$sub_dir);
            }
            //5.控制文件上传类型
                //01通过文件后缀
                //定义可以上传的文件后缀
                    if(!in_array($ext,$this->_ext_allow_list)){
                        echo '<br>文件类型不对error1';
                        return false;
                    }
                //02验证文件资源类型的mime
                    //定义可以上传的mime的资源类型
                    if(!in_array($file_info['type'], $this->_mime_allow_list)){
                        echo '<br> 文件mime类型错误error2';
                        return false;
                }

                //03使用第三方
                    $finfo = new Finfo(FILEINFO_MIME_TYPE);
                    //获取上传文件的真正mime类型
                    $mime_type = $finfo->file($file_info['tmp_name']);
                    if(!in_array($mime_type, $this->_mime_allow_list)){
                        echo '文件mime类型错误error3';
                        return false;
                    }


            //转移文件，从临时文件往服务器指定文件夹转移tmp_name
                   if(move_uploaded_file($file_info['tmp_name'],$this->_upload_path.$sub_dir.$upload_filename)){
                       $address = $sub_dir.$upload_filename;
                       //返回上传文件的目录
                       echo '上传成功！';
                       return $address;
                       //$sql = "INSERT INTO `upload` VALUES(NULL,'$address')";
                           //return true;
                   }else{
                           return false;
                   }


        }

}

