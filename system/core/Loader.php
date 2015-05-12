<?php
defined("APPPATH") OR exit("No direct script access allowed");
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/5/4
 * Time: 9:25
 */

/**
 * Class Loader
 * 加载各个分支的类
 */
    class  Loader
    {
        function __construct()
        {
            $this->SR =& get_instance();
        }

        public function helper($helperFileName)
        {
            if(!is_file(APPPATH."../application/helpers/".$helperFileName.".php"))
            {
                exit("helper file not found");
            }
            require_once(APPPATH."../application/helpers/".$helperFileName.".php");
            if(class_exists($helperFileName))
            {
                $this->$helperFileName = new $helperFileName();
            }
        }

        public function model($modelFileName)
        {
            if(!is_file(APPPATH."../application/models/".$modelFileName.".php"))
            {
                exit("model file not found");
            }
            require_once(APPPATH."../application/models/".$modelFileName.".php");
            if(class_exists($modelFileName))
            {

                $name = new $modelFileName;
                $this->SR->$modelFileName = $name;
            }
        }




    }