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

    require_once("Controller.php");

    $_URI = explode("/", ltrim(str_replace("/index.php", "", $_SERVER["REQUEST_URI"]),"/") );
    if(count($_URI) >= 3 )
    {
        $_class_name = $_URI["1"];
        $_fun_name = $_URI["2"];
    }
    else
    {
        $_class_name = "app";
        $_fun_name = "index";
    }


    require_once(CPATH.$_class_name.".php");

    $_class_name = new $_class_name();

    $_class_name->$_class_name();





