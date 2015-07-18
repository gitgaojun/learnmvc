<?php
defined("APPPATH") OR exit("No direct script access allowed");
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/5/14
 * Time: 11:11
 */

    function exceptionPack($message = 'false')
    {
        try{
            throw new Exception($message);
        }catch ( Exception $e )
        {
            echo "throw Exception:" . $e->getMessage() . "\n";
        }
    }