<?php
/*  ����ģ��
 * �����ģ�͵Ļ��࣬�ܶ��ģ�Ͷ�����ͬ�Ĳ���
 * ���ǰ��ظ��Ĵ�����ڻ�����
 */
namespace Core;

class Model{
    //����DAO����
    protected $dao;
    public function __construct(){
        //�������ݿ�
        $this->dao = new MyPDO();
    }
}