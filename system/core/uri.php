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
        function __construct()
        {
            $this->init();
        }


        /**
         * 解析url规则
         * return array         array('c'=>'控制器名', 'm'=>'方法名' ， 'p'=>array('...'));
         *                      www.acon.com/blog/              blog index
         *                      www.acon.com/blog/del.html      blog del
         *                      www.acon.com/blog/del.html      blog del ?request_string
         */
        protected function init()
        {
            $uri_string = $_SERVER["REQUEST_URI"];
            $preg = '^\/(.*)\/(.*)\.html\?$';
        }



    }

