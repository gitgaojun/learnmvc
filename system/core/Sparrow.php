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
    require_once("Model.php");
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





