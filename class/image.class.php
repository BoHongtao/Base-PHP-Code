<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 2017/6/6
 * Time: 20:32
*/
class image
{
    /*显示错误信息*/
    public function showError($msg){
        echo($msg);
        return false;
    }

    /*获取图片信息*/
    public function getInfo($image){
        if(getimagesize($image)){
            return getimagesize($image);
        }else{
            $this->showError('获取不到待处理的图片或水印图片');
        }
    }

    /*给图片添加水印*/
    public function watermark($dst,$src,$position=9,$path='',$pct=50){
        /*
         * 参数说明
         * $dst - 需要添加水印的图片
         * $src - 水印图片
         * $position - 水印位置（可选参数为1~9，其中1为左上角，9为右下角，按九宫格排列）
         * $pct - 水印的透明度（0~100 其中100为完全不透明）
         * $path - 图片保存位置（文件夹名称；如果获取不到该参数，将覆盖原图；如果获取到该参数，将在原图所在文件夹下创建相应的子目录，不会覆盖原图）
         * */
        if(empty($dst) || empty($src)){
            $this->showError('待处理的图片和水印图片必填');
        }
        /*获取图片信息（$dst_info-待处理的图片，$src_info-水印图片）*/
        $dst_info = $this->getInfo($dst);
        $src_info = $this->getInfo($src);
        /*根据图片的MIME类型，动态的构造一个 由文件或URL地址创建新图像的函数（imagecreatefromjpeg/imagecreatefrompng/imagecreatefromgif）*/
        $createFromDst = str_replace('/','createfrom',$dst_info['mime']);
        $createFromSrc = str_replace('/','createfrom',$src_info['mime']);
        /*创建图像资源（$dst-待处理的图像资源，$src-水印图像资源）*/
        $dst_im = $createFromDst($dst);
        $src_im = $createFromSrc($src);
        /*确定水印位置*/
        /*if($position%3 == 1){// 1/4/7
            $dst_x = 0;
        }else if($position%3 == 2){// 2/5/8
            $dst_x = ($dst_info[0]-$src_info[0])/2;
        }else if($position%3 == 0){// 3/6/9
            $dst_x = $dst_info[0]-$src_info[0];
        }
        if($position<=3){
            $dst_y = 0;
        }else if($position<=6){
            $dst_y = ($dst_info[1]-$src_info[1])/2;
        }else if($position<=9){
            $dst_y = $dst_info[1]-$src_info[1];
        }*/

        switch($position){
            case '1':
                $dst_x = 0;
                $dst_y = 0;
                break;

            case '2':
                $dst_x = ($dst_info[0]-$src_info[0])/2;
                $dst_y = 0;
                break;

            case '3':
                $dst_x = $dst_info[0]-$src_info[0];
                $dst_y = 0;
                break;

            case '4':
                $dst_x = 0;
                $dst_y = ($dst_info[1]-$src_info[1])/2;
                break;

            case '5':
                $dst_x = ($dst_info[0]-$src_info[0])/2;
                $dst_y = ($dst_info[1]-$src_info[1])/2;
                break;

            case '6':
                $dst_x = $dst_info[0]-$src_info[0];
                $dst_y = ($dst_info[1]-$src_info[1])/2;
                break;

            case '7':
                $dst_x = 0;
                $dst_y = $dst_info[1]-$src_info[1];
                break;

            case '8':
                $dst_x = ($dst_info[0]-$src_info[0])/2;
                $dst_y = $dst_info[1]-$src_info[1];
                break;

            case '9':
                $dst_x = $dst_info[0]-$src_info[0];
                $dst_y = $dst_info[1]-$src_info[1];
                break;

            default:
                $this->showError('水印位置（可选参数为1~9，其中1为左上角，9为右下角，按九宫格排列）');
        }

        /*判断水印图片MIME类型，用相应的函数来添加水印*/
        if($src_info['mime'] == 'image/png'){
            imagecopy($dst_im,$src_im,$dst_x,$dst_y,0,0,$src_info[0],$src_info[1]);
        }else{
            imagecopymerge($dst_im,$src_im,$dst_x,$dst_y,0,0,$src_info[0],$src_info[1],$pct);
        }

        /*判断存储目录是否存在，不存在创建之*/
        if($path == ''){
            $fullPath = $dst;
        }else{
            $fileName = basename($dst);
            $dir = str_replace($fileName,'',$dst).$path.'/';
            if(!file_exists($dir)){
                mkdir($dir,0777,true);
            }
            $fullPath = $dir.$fileName;
        }
        /*根据图片的MIME类型；动态的构造一个将图像输出到浏览器或文件的函数（imagejpeg/imagepng/imagegif）*/
        $saveDst = str_replace('/','',$dst_info['mime']);
        $saveDst($dst_im,$fullPath);
        /*销毁图像资源*/
        imagedestroy($dst_im);
        imagedestroy($src_im);
    }

    /*
     * 生成缩略图
     * $src - 待处理的图片
     * $dst_w - 缩略图的宽度
     * $path - 缩略图的存储目录
     * $delSrc - 是否删除原图
     * */
    public function thumbnail($src,$dst_w=120,$path='thumb',$delSrc=false){
        $src_info = $this->getInfo($src);
        /*根据图片的MIME类型，动态的构造一个 由文件或URL地址创建新图像的函数（imagecreatefromjpeg/imagecreatefrompng/imagecreatefromgif）*/
        $createFrom = str_replace('/','createfrom',$src_info['mime']);//image/png -> imagecreatefrompng
        $src_im = $createFrom($src);
        /*创建一个图像*/
        $dst_h = $dst_w*$src_info[1]/$src_info[0];//src_w/src_h = dst_w/dst_h
        $dst_im = imagecreatetruecolor($dst_w,$dst_h);
        /*拷贝图片*/
        imagecopyresampled($dst_im,$src_im,0,0,0,0,$dst_w,$dst_h,$src_info[0],$src_info[1]);
        /*判断存储目录是否存在*/
        $fileName = basename($src);
        $dir = str_replace($fileName,'',$src).$path.'/';
        if(!file_exists($dir)){
            mkdir($dir,0777,true);
        }
        $fullPath = $dir.$fileName;
        /*根据图片的MIME类型；动态的构造一个将图像输出到浏览器或文件的函数（imagejpeg/imagepng/imagegif）*/
        $save = str_replace('/','',$src_info['mime']);
        $save($dst_im,$fullPath);
        if($delSrc) unlink($src);
        /*/销毁图像*/
        imagedestroy($src_im);
        imagedestroy($dst_im);
    }

    /*
     * 生成验证码
     * $w - 验证码的宽度
     * $h - 验证码的高度
     * $n - 验证码的长度
     * */
    public function verify($w=70,$h=25,$n=4){
        header('Content-type:image/png');
        /*创建一个真彩色图像*/
        $im = imagecreatetruecolor($w,$h);
        /*创建一个配色数组*/
        $colors = array(
            array(array(249,243,159),array(130,189,63),array(113,80,39),array(175,24,39),array(227,25,41)),
            array(array(27,84,31),array(210,157,113),array(243,204,51),array(229,23,35),array(234,221,231)),
            array(array(114,1,44),array(126,40,51),array(221,148,165),array(217,28,35),array(122,192,60)),
            array(array(30,1,85),array(180,153,98),array(238,159,64),array(133,71,58),array(229,224,231))
        );
        /*随机取一种配色*/
        $randColor = $colors[mt_rand(0,3)];
        /*为图像分配颜色*/
        $bgColor = imagecolorallocate($im,$randColor[0][0],$randColor[0][1],$randColor[0][2]);
        /*填充背景色*/
        imagefill($im,0,0,$bgColor);
        /*画3条椭圆弧*/
        $arcColor = imagecolorallocate($im,$randColor[1][0],$randColor[1][1],$randColor[1][2]);
        for($i=1;$i<=3;$i++){
            imagearc($im,mt_rand(0,$w/2),mt_rand(0,$h/2),mt_rand(0,$w*2/3),mt_rand(0,$h*2/3),mt_rand(0,360),mt_rand(0,360),$arcColor);
        }
        /*画6条直线*/
        $lineColor = imagecolorallocate($im,$randColor[2][0],$randColor[2][1],$randColor[2][2]);
        for($i=1;$i<=6;$i++){
            imageline($im,mt_rand(0,$w),mt_rand(0,$h),mt_rand(0,$w),mt_rand(0,$h),$lineColor);
        }
        /*画9个像素点*/
        $pixelColor = imagecolorallocate($im,$randColor[3][0],$randColor[3][1],$randColor[3][2]);
        for($i=1;$i<=9;$i++){
            imagesetpixel($im,mt_rand(0,65),mt_rand(0,20),$pixelColor);
        }
        /*写$n位的验证码*/
        $fontColor = imagecolorallocate($im,$randColor[4][0],$randColor[4][1],$randColor[4][2]);
        $fontFile = 'fonts/1.ttf';
        $verify = '';
        for($i=0;$i<$n;$i++){
            $text = strtoupper(dechex(mt_rand(0,15))); //0~9 A~F
            imagettftext($im,$h*3/5,mt_rand(0,30),$w/14+$w*6/7/$n*$i,$h*4/5,$fontColor,$fontFile,$text);
            $verify .= $text;
        }
        session_start();
        $_SESSION['verify'] = $verify;
        /*显示验证码*/
        imagepng($im);
    }
}
?>