<?php
require_once 'Wechat.class.php';
require_once 'get_token.php';
require_once 'common.php';
define("TOKEN", "weixin");

class wechatCallbackapiTest extends Wechat
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//接收微信客户端发送过来的XML数据
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//判断数据是否为空
		if (!empty($postStr)){
                //主要功能：防止XXE攻击
                libxml_disable_entity_loader(true);
                //对XML数据进行解析生成simplexml对象
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                //微信的客户端openid
                $fromUsername = $postObj->FromUserName;
                //微信公众平台
                $toUsername = $postObj->ToUserName;
                //微信客户端向公众平台发送的关键词
                $keyword = trim($postObj->Content);
                file_put_contents('wx.log',$keyword,FILE_APPEND);
                 //时间戳
                $time = time();
                 //调用$tmp_arr
                global $tmp_arr;
                //接收MsgType节点并判断其值
                switch ($postObj->MsgType) {
                    case 'text':
                        //定义相关变量
                         $msgType = "text";
                         //$contentStr = "您发送的是文本消息！";
                         //$resultStr = sprintf($tmp_arr['text'], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                         //echo $resultStr;
                        if($keyword == '音乐'){
                            $msgType = 'music';
                            $title = '刀山火海';
                            $description = '原生大碟';
                            $url = 'http://39.106.15.73/music.mp3';
                            $hqurl = 'http://39.106.15.73/music.mp3';
                           //使用sprintf函数对music模板进行格式化
                            $resultStr = sprintf($tmp_arr['music'], $fromUsername, $toUsername, $time, $msgType, $title, $description, $url, $hqurl);
                            file_put_contents('wx.log', $resultStr, FILE_APPEND);
                            //返回格式化后的XML数据到客户端
                            echo $resultStr;
                        }else if($keyword == '单图文') {
                            //定义相关的变量
                            $msgType = "news";
                            $count = 1;
                            $str = '<item>
                                    <Title><![CDATA[最实用的47个让你拍照好看的方法]]></Title> 
                                    <Description><![CDATA[怎样拍照好看?有个会拍照的男朋友是怎么样的体验?怎么样把女朋友拍得漂亮...]]></Description>
                                    <PicUrl><![CDATA[http://39.106.15.73/image/1.jpg]]></PicUrl>
                                    <Url><![CDATA[http://39.106.15.73/]]></Url>
                                    </item>';
                            //使用sprintf函数对XML模板进行格式化
                            $resultStr = sprintf($tmp_arr['news'], $fromUsername, $toUsername, $time, $msgType, $count, $str);
                            //使用file_put_contents把格式化后的XML代码写入到日志中
                            file_put_contents('wx.log', $resultStr, FILE_APPEND);
                            //返回格式化后的XML数据到客户端
                            echo $resultStr;
                        }
                        break;

                    case 'image':
                        $msgType = "text";
                        $contentStr = "您发送的是图片消息！";
                        $resultStr = sprintf($tmp_arr['text'], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    break;

                    case 'voice':
                        //1、接收微信语音识别结果
                        $rec = $postObj->Recognition;
                        //2、定义请求的url地址
                        $url = "http://www.tuling123.com/openapi/api";
                        //3、第一步：创建curl
                        $ch = curl_init();
                        //4、第二步：设置curl
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        //定义要传输的数据
                        $data = array(
                            'key'=>'2f5458b9cf9d4febba20f7e88ed3f07c',
                            'info'=>$rec,
                            'userid'=>'12345678'
                        );
                        //使用json_encode转化为json格式
                        $data = json_encode($data);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        //设置HTTP头信息
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Content-Type:application/json',
                                'Content-Length:'.strlen($data))
                        );
                        //5、第三步：执行curl
                        $str = curl_exec($ch);
                        //6、第四步：关闭curl
                        curl_close($ch);
                        //7、使用json_decode进行转义操作
                        $json = json_decode($str);
                        //8、使用文本回复接口把图灵的返回信息发送到客户端
                        $msgType = "text";
                        $contentStr = $json->text;
                        $resultStr = sprintf($tmp_arr['text'], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    break;

                    //判断是否是第一次订阅，显示感谢关注的信息
                    case 'event':
                        if($postObj->Event == 'subscribe') {
                            $msgType = "text";
                            $contentStr = "感谢您关注!";
                            $resultStr = sprintf($tmp_arr['text'], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            echo $resultStr;
                        }
                         //判断单击按钮的事件推送
                        if($postObj->Event == 'CLICK' && $postObj->EventKey == 'V1001_TODAY_MUSIC') {
                            $msgType = 'music';
                            $title = '刀山火海';
                            $description = '原生大碟';
                            $url = 'http://39.106.15.73/music.mp3';
                            $hqurl = 'http://39.106.15.73/music.mp3';
                           //使用sprintf函数对music模板进行格式化
                            $resultStr = sprintf($tmp_arr['music'], $fromUsername, $toUsername, $time, $msgType, $title, $description, $url, $hqurl);
                            //file_put_contents('wx.log', $resultStr, FILE_APPEND);
                            //返回格式化后的XML数据到客户端
                            echo $resultStr;
                        }
                        //判断单击按钮的事件推送
                        if($postObj->Event == 'CLICK' && $postObj->EventKey == 'V1001_GOOD') {
                            $msgType = 'text';
                            $contentStr = "谢谢!";
                            //使用sprintf函数对music模板进行格式化
                            $resultStr = sprintf($tmp_arr['text'], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                            //返回格式化后的XML数据到客户端
                            echo $resultStr;
                        }

                    break;

                     //获取用户的地址位置
                    case 'location':
                        $msgType = 'text';
                        //获取经度
                        $longitude = $postObj->Location_Y;
                        //获取维度
                        $latitude = $postObj->Location_X;
                        $keyword = urlencode('肯德基');
                        $url = "http://restapi.amap.com/v3/place/around?key=7d1ac2950aaf4aa870a41fa825ac758f&location={$longitude},{$latitude}&keywords={$keyword}&types=050301&offset=1&page=1&extensions=all";
                        //$contentStr = "你发送的位置是维度{$longitude},经度{$latitude}";
                       // $resultStr = sprintf($tmp_arr['text'],$fromUsername, $toUsername, $time, $msgType, $contentStr);
                        //echo $resultStr;
                        //发送请求
                        $str = $this->http_request($url);
                        //使用json_decode对$str进行转义，生成$json对象
                        $json = json_decode($str);
                        //获取店铺名称、地址位置、电话、距离长度
                        $name = $json->pois[0]->name;
                        $address = $json->pois[0]->address;
                        $tel = $json->pois[0]->tel;
                        $distance = $json->pois[0]->distance;
                        //以文本形式返回数据
                        $msgType = "text";
                        $contentStr = "你发送的位置是维度{$longitude},经度{$latitude},离您最近的KFC，名称：{$name}，详细地址：{$address}，联系电话：{$tel}，距离长度：{$distance}";
                        $resultStr = sprintf($tmp_arr['text'], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                        break;
                    break;
                    }
                    }else {
                        echo "";
                        exit;
                    }
    }
		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}
$wechatObj = new wechatCallbackapiTest();
// $wechatObj->valid();
//开启自动回复
$wechatObj->responseMsg();
?>