<?php
defined("APPPATH") OR exit("No direct script access allowed");
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/5/14
 * Time: 9:20
 */

    /**
     * 设置数据库的配置信息
     */
    $databaseName = "learnmvc";
    $database["learnmvc"] = array(
        "host"          =>      "localhost",
        "port"          =>      "3306",
        "user"          =>      "root",
        "pwd"           =>      "123456",
        "database"     =>       "learnmvc",
        "charset"      =>       "utf-8",
    );
    $database["test"] = array(
        "host"              =>       "localhost",
        "port"              =>       "3306",
        "user"              =>       "root",
        "pwd"               =>       "123456",
        "database"         =>        "test",
        "charset"          =>        "utf-8",
	);
	$database['sparrow'] = array(
		'host'				=>		'localhost',
		'port'				=>		'3306',
		'user'				=>		'root',
		'pwd'				=>		'123456',
		'database'			=>		'sparrow',
		'charset'			=>		'utf-8',
	);
