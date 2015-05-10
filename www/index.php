<?php 
//单一入口

//网站的地址
define("WEB", "http://www.learnmvc.com/");

//文件的路径
define("APPPATH", str_replace("\\","/",rtrim(__DIR__,"/")."/"));
//控制器的路径
define("CPATH", rtrim(APPPATH."../application/controllers","/")."/");
//模版的路径
define("MPATH", rtrim(APPPATH."../application/models","/")."/");
//视图的路径
define("VPATH", rtrim(APPPATH."define/views", "/")."/");
//系统路径
define("SYSPATH", rtrim(APPPATH."../system", "/")."/");
//视图文件后缀
define("EXT", ".html");
//js文件路径
define("JSPATH", rtrim(WEB."define/js", "/")."/");
//css文件路径
define("CSSPATH", rtrim(WEB."define/css", "/")."/");
//image文件路径
define("IMAGEPATH", rtrim(WEB."define/img", "/")."/");

//开启session
session_start();


require_once(SYSPATH."core/Sparrow.php");
