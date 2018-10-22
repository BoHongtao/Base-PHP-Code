<?php
    //1、设置响应头信息
    header('Content-type:text/html; charset=utf-8');
    //2、载入get_token.php
    require 'get_token.php';
    //3、定义请求的url地址
    $url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token={$access_token}";
    //获取用户列表信息放str中
    $url2 = "https://api.weixin.qq.com/cgi-bin/user/get?access_token={$access_token}";
    $str = json_decode(http_request($url2));
    //用户列表
    $touser = $str->data->openid;
//    var_dump($touser);die;
    //4、定义要携带的JSON数据
    $msg = '这是一条群发消息a';
      $data = array(
          "touser"=>'',
          "msgtype"=>'text',
          "text"=>array("content"=>$msg)
      );
    $data['touser'] = $touser;
    $data['text']['content'] = $msg;

    $data = json_encode($data,JSON_UNESCAPED_UNICODE);
    //5、使用http_request函数发送请求
    http_request($url, $data);
    //6、信息提示
    echo '群发消息发送成功！';