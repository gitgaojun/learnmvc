<?php defined("APPPATH") or exit("No direct script access allowed");
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/7/14
 * Time: 17:35
 */

    /**
     * Class Uri 解析url
     */
    class Uri
    {

        /**
         * 解析url规则
         * @access public
         * @return array         array('c'=>'控制器名', 'm'=>'方法名' ， 'p'=>array('...'));
         *                      www.acon.com/blog/              blog index
         *                      www.acon.com/blog/del.html      blog del
         *                      www.acon.com/blog/del.html      blog del ?request_string
         */
        public function init()
        {
            $uri_string = $_SERVER["REQUEST_URI"];
            //php 中的正则有点奇怪用的是 //隔开来定位的正则开始匹配位
            //$preg = '/^(.*)$/';
            //$preg = '/^\/(.*)\/(.*)\.html$/';
            //preg_match_all( $preg , $uri_string , $uri);


            if($uri_string === '/')
            {
                $uri['c'] = 'app';
                $uri['m'] = 'index';
            }
            if(substr_count($uri_string , '/') === 2 && substr_count($uri_string , '.html') <1)
            {
                $preg = '/^\/(.*)\/(.*)$/';
                preg_match_all( $preg , $uri_string , $preg_cw);
                $uri['c'] = $preg_cw[1][0];
                $uri['m'] = empty($preg_cw[2][0])?'index':$preg_cw[2][0];
            }
            if(substr_count($uri_string , '/') === 2 && substr_count($uri_string , '.html') === 1 && substr_count($uri_string , '.html?') < 1)
            {
                $preg = '/^\/(.*)\/(.*)\.html$/';
                preg_match_all( $preg , $uri_string , $preg_cw );
                $uri['c'] = $preg_cw[1][0];
                $uri['m'] = $preg_cw[2][0];
            }
            if(substr_count($uri_string , '/') === 2 && substr_count($uri_string , '.html') === 1 && substr_count($uri_string , '.html?') === 1)
            {
                $preg = '/^\/(.*)\/(.*)\.html\?(.*)$/';
                preg_match_all( $preg , $uri_string , $preg_cw );
                $uri['c'] = $preg_cw[1][0];
                $uri['m'] = $preg_cw[2][0];
                //$_GET $_POST  在读取的时候已经被解析好了
            }
            return $uri;
        }



    }

