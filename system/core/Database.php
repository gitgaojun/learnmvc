<?php
defined("APPPATH") OR exit("No direct script access allowed");
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/5/14
 * Time: 9:17
 */

    class Database
    {
        function __construct($db = "default")
        {
            if(!is_file( APPPTAH . "../../config/database.php" ))
            {
                exceptionPack("config/database.php is not exist");
            }
            require_once( APPPATH . "../application/config/database.php" );
            $this->set = $db;
        }
    }

