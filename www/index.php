<?php 


//文件的路径
define("APPPATH", rtrim(__DIR__,"/")."/");
//控制器的路径
define("CDIR", rtrim(APPPATH."../application/controllers","/")."/");
//模版的路径
define("MDIR", rtrim(APPPATH."../application/models","/")."/");
//视图的路径
define("VDIR", rtrim(APPPATH."define", "/")."/");
//系统路径
define("SYSDIR", rtrim(APPPATH."../system", "/")."/");



require_once(SYSDIR."core/Sparrow.php");
