<?php
    //1、定义响应头信息
    header('Content-type:text/html; charset=utf-8');
    //2、载入get_token.php页面到此页面中
    require 'get_token.php';
    //3、定义自定义菜单的创建接口
    $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
    //4、定义要携带的数据
    $data = ' {
         "button":[
         {	
              "type":"click",
              "name":"今日歌曲",
              "key":"V1001_TODAY_MUSIC"
          },
          {
               "name":"菜单",
               "sub_button":[
               {	
                   "type":"view",
                   "name":"搜索",
                   "url":"http://www.baidu.com/"
                },
                {
                   "type":"view",
                   "name":"看个视频",
                   "url":"http://v.qq.com/"
                },
                {
                   "type":"click",
                   "name":"夸夸我们",
                   "key":"V1001_GOOD"
                }]
           }]
     }';
    //5、发送http请求
    $str = http_request($url, $data);
    //6、使用json_decode函数进行转义
    $json = json_decode($str);
    //7、判断是否创建成功
    if($json->errmsg == 'ok') {
        echo '自定义菜单创建成功！';
    }