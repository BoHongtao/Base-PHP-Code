<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017/3/3
 * Time: 19:45
 */
   final class DAOMySQLi{
        private $_host;
        private $_user;
        private $_pwd;
        private $_db;
        private $_port;
        private $_charset;
        private static $_instance;

        private $_mySQLi;

        /**
         * DAOMySQLi constructor.
         * @param array $option
         */
        private function __construct(array $option = array())
        {

            //初始化成员变量
            $this->_initOption($option);
            //初始化_MySQLi 对象
            $this->_initMySQLi();

        }
        //初始化成员变量
        private function _initOption(array $option = array())
        {
            $this->_host    = isset( $option['host'] )    ? $option['host']    : '';
            $this->_user    = isset( $option['user'] )    ? $option['user']    : '';
            $this->_pwd     = isset( $option['pwd'] )     ? $option['pwd']     : '';
            $this->_db      = isset( $option['db'] )      ? $option['db']      : '';
            $this->_port    = isset( $option['port'] )    ? $option['port']    : '';
            $this->_charset = isset( $option['charset'] ) ? $option['charset'] : '';

        }
       //初始化_MySQLi 对象
        private function _initMySQLi()
        {
            //判断参数是否正确
            if($this->_host === '' || $this->_user === '' || $this->_pwd ==='' ||$this->_db ===''
                ||$this->_port === '' || $this-> _charset = ''
            ){
                die('参数错误');
            }
            //初始化$this->_mySQLi
            $this->_mySQLi = new MySQLi($this->_host,$this->_user,$this->_pwd,
                $this->_db,$this->_port);
            if($this->_mySQLi->connect_errno){
                die('获取mysqli对象失败 错误信息：'.$this->_mySQLi->connect_error);
            }
            //设置字符集
            $this->_mySQLi->set_charset($this->_charset);
        }
        //阻止克隆
        private function __clone()
        {

        }

       public  static function getSingleton(array $option = array())
        {
            if(!self::$_instance instanceof self)
            {
                self::$_instance = new self($option);
                return self::$_instance;
            }
        }
        //成员方法完成查询所有任务
        public function fetchAll($sql = '')
        {
            echo "sql语句是".$sql;
            echo '<br>';
            //空数组
            $arr = array();
            if($res = $this->_mySQLi->query($sql)) {
                while ($row = $res->fetch_assoc()) {
                    $arr[] = $row;
                }
                $res->free();
            }else{
                echo '<br>查询失败';
                die($this->_mySQLi->error);
            }
                return $arr;

        }
        //成员方法用来返回一条记录:前提是你知道数据库中仅有一条这样的记录，通常用来查询主键
        public function fetch($sql = '')
        {
            echo "查询语句是".$sql;
            echo '<br>';
            if($res = $this->_mySQLi->query($sql)) {
                $row = $res->fetch_assoc();
                $res->free();
            }else {
                echo '<br>查询失败,错误信息：';
                die($this->_mySQLi->error);
            }
            return $row;
        }
        //成员方法，完成dml任务
        public function mydml($sql = '')
        {
            echo "sql语句是：".$sql;
            echo '<br>';
            $res = $this->_mySQLi->query($sql);
            if(!$res){
                echo "执行操作失败，错误信息如下：".
                    $this->_mySQLi->error;
                die($this->_mySQLi->error);
            }
            return $res;
        }

    }