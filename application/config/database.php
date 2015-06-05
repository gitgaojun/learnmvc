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
    $databaseName = "default";
    $database["default"] = array(
        "host"          =>      "127.0.0.1",
        "port"          =>      "3306",
        "user"          =>      "root",
        "pwd"           =>      "123456",
        "database"     =>       "learnmvc",
        "charset"      =>       "utf-8",
    );
    $database["test"] = array(
        "host"              =>       "127.0.0.1",
        "port"              =>       "3306",
        "user"              =>       "root",
        "pwd"               =>       "123456",
        "database"         =>        "test",
        "charset"          =>        "utf-8",
    );
