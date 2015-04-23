<?php 


//文件的路径
define("APPPATH", rtrim(__DIR__,"/")."/");
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

require_once(SYSPATH."core/Sparrow.php");
