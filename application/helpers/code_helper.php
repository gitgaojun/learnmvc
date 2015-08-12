<?php
defined("APPPATH") or exit("No direct script access allowed");

/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/4/28
 * Time: 14:46
 */

    if(!function_exists("codeImage"))
    {
        /**
         * 画一个验证码
         * @param 长度 $x
         * @param 宽度 $y
         * @param session键值 $codeName
         */
        function codeImage($x,$y,$codeName){
            header('Content-type:image/png');
            //$imageWidth = 200;$imageHeight = 50;
            $imageWidth = $x;$imageHeight = $y;
            $codeList = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $im = @imagecreate($imageWidth,$imageHeight)
            or die("创建图像失败");
            $backgroundColor = imagecolorallocate($im,255,255,255);
            $filledarcColor = imagecolorallocate($im,rand(155,255),rand(155,255),rand(155,255));
            $textColor = imagecolorallocate($im,rand(0,155),rand(0,155),rand(0,155));
            for($i=1;$i<5;$i++){
                $textContent[$i]=substr($codeList,rand(0,61),1);

            }
            //echo 3;exit;
            $_SESSION[$codeName] = implode($textContent);
            $j=2;
            while($j>0){
                imagefilledarc($im,rand(0,$imageWidth),rand(0,$imageHeight),rand($imageWidth/5,$imageWidth/3),rand($imageHeight*2,$imageHeight*3),
                    rand(0,30),rand(0,30),$filledarcColor,IMG_ARC_PIE);
                $j--;
            }
            for($i=1;$i<5;$i++){
                imagettftext($im,rand(20,30),rand(-30,30),$i*$imageWidth/5-4,3*$imageHeight/4,$textColor,APPPATH."define/font/ELEPHNT.TTF",$textContent[$i]);
            }

            imagepng($im);
            imagedestroy($im);
        }
    }


    if( !function_exists('getRealIp') )
    {

        /**
         * 获取真实ip地址
         *
         * @since 2015-8-12
         * @author jun
         * @return mixed
         */
        function getRealIp()
        {
            if( !empty($_SERVER['HTTP_CLIENT_IP']) )  // apache 可配置 nginx现在不会。不知道有没有
            {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            elseif( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) )
            {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; // 如果客户端通过代理服务器，则取 HTTP_X_FORWARDED_FOR 的值
            }
            else
            {
                $ip = $_SERVER['REMOTE_ADDR'];
            }


            return $ip;
        }
        /*HTTP_CLIENT_IP 是代理服务器发送的HTTP头。如果是“超级匿名代理”，则返回none值。同样，REMOTE_ADDR也会被替换为这个代理服务器的IP。
        $_SERVER['REMOTE_ADDR']; //访问端（有可能是用户，有可能是代理的）IP
        $_SERVER['HTTP_CLIENT_IP']; //代理端的（有可能存在，可伪造）
        $_SERVER['HTTP_X_FORWARDED_FOR']; //用户是在哪个IP使用的代理（有可能存在，也可以伪造）*/
    }