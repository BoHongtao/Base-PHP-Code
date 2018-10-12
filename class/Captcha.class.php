<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017/3/12
 * Time: 22:07
 * 验证码工具类
 * Completely Automated Public Turing Test to Tell Computers and Humans Apart
 */
class Captcha {
    //画布的大小
    public $width = 100;
    public $height = 40;
    //验证码的长度
    public $code_len = 4;
    public $pixel_number = 100;
    private function _mkCode() {
        // 有4位，大写字母和数字组成
        // 所有的可能的字符集合
        $chars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789abcdefghijklmnopqrstuvwxyz';
        $chars_len = strlen($chars);// 集合长度
        // 随机选取
        $code = '';// 验证码值初始化
        for($i=0; $i<$this->code_len; ++$i) {
            // 随机取得一个字符下标
            $rand_index = mt_rand(0, $chars_len-1);
            // 利用字符串的下标操作，获得所选择的字符
            $code .= $chars[$rand_index];
        }
        // 存储于session中
        @session_start();
        $_SESSION['captcha_code'] = $code;
        return $code;
    }
    /**
     * 生成验证码图片
     * @param int $code_len 码值长度
     */
    public function makeImage() {
        // 一：处理码值
        $code = $this->_mkCode();
        // 二，处理图像
        // 创建画布
        $image = imagecreatetruecolor($this->width, $this->height);
        // 设置背景颜色
        $bg_color = imagecolorallocate($image, mt_rand(180,255), mt_rand(180,255), mt_rand(180,255));
        //设置字体颜色
        $str_color = imagecolorallocate($image, mt_rand(0,100), mt_rand(0,100), mt_rand(0,100));
        // 填充背景
        imagefill($image, 0, 0, $bg_color);
        // 内置5号字体
        $font = 5;
        // 位置
        // 画布大小
        $image_w = imagesx($image);
        $image_h = imagesy($image);
        // 字体宽高
        $font_w = imagefontwidth($font);
        $font_h = imagefontheight($font);
        // 字符串宽高
        $str_w = $font_w * $this->code_len;
        $str_h = $font_h;
        // 计算位置
        $str_x = ($image_w - $str_w) / 2;
        $str_y = ($image_h-$str_h) / 2;

        // 字符串放画布上
        imagestring($image, $font, $str_x, $str_y, $code, $str_color);
        //imagettftext($image,$font,0,$str_x, $str_y,$str_color,'STCAIYUN.TTF','$code');

        // 添加噪点
        for($i=1; $i<=$this->pixel_number; ++$i) {
            $color = imagecolorallocate($image, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
            imagesetpixel($image, mt_rand(0, $this->width-1), mt_rand(0,$this->height-1), $color);
        }
        //干扰线
        for($i = 1;$i<=10 ;++$i){
            $linecolor = imagecolorallocate($image, mt_rand(100,180), mt_rand(100,180), mt_rand(100,180));
            imageline($image, mt_rand(0,200), mt_rand(0,70), mt_rand(0,200), mt_rand(0,70), $linecolor);
        }

        // 输出，销毁画布
        ob_clean();
        header('Content-Type: image/jpeg');
        imagejpeg($image);
        imagedestroy($image);
    }
    /**
     * 验证用户输入验证码是否正确
     * @param string $post_code 用户输入的验证码
     */
    public function checkCode($post_code) {
        @session_start();
        // 先判断验证码合法性
        $result = isset($post_code) && // 用户输入的存在
            isset($_SESSION['captcha_code']) && // session中存在
            strtoupper($post_code) == strtoupper($_SESSION['captcha_code']); // 相等
        // 无论是否相等，都需要删除掉session中存在的验证码,然后重新生成!
        if (isset($_SESSION['captcha_code'])) { unset($_SESSION['captcha_code']); }
        // 返回验证结果
        return $result;
    }
}