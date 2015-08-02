<?php
defined("APPPATH") OR exit("No direct script access allowed");
header('Transfer-Encoding:Identity');// 设置字符编码
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/4/22
 * Time: 11:14
 */
/**
 * 主要用来整合各个文件，和实例化各个对象，以及整合视图
 */

    //设置开发环境的错误提示
    switch(ENVIRONMENT)
    {
        case "development":
            ini_set("display",1);
        break;
        case "production":
            ini_set("display",0);
        break;
    }

    ini_set('zlib.output_compression', 1);//开启gzip压缩 ,提速

    require_once("Exception.php");//定义的异常处理的方法
    require_once("Controller.php");
    function &get_instance()
    {
        return SR_Controller::get_instance();
    }
    require_once("Model.php");
    function &get_instance_model()
    {
        return SR_Model::get_instance_model();
    }

    require_once('uri.php');
    $_URI = new Uri();
    $uri = $_URI->init();
    $_class_name = $uri['c'];
    $_fun_name = $uri['m'];

    require_once(CPATH.$_class_name.".php");

    $_className = new $_class_name();

    $_className->$_fun_name();





