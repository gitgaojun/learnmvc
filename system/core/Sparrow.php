<?php
defined("APPPATH") OR exit("No direct script access allowed");
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
    $_URI = explode("/", ltrim(str_replace("/index.php", "", $_SERVER["REQUEST_URI"]),"/") );
    if(count($_URI) >= 2 )
    {
        $_class_name = $_URI["0"];
        $_fun_name = $_URI["1"]?$_URI["1"]:"index";
    }
    else
    {
        $_class_name = "app";
        $_fun_name = "index";
    }
    //var_dump($_URI, $_class_name, $_fun_name);exit;

    require_once(CPATH.$_class_name.".php");

    $_className = new $_class_name();

    $_className->$_fun_name();





