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
        function __construct($pClass)
        {
            $this->initiative($pClass);

            //$this->initiative();
        }

        /**
         * 用来判断需要被引用的接口是哪一个
         * @param $pClass string
         */
        private function initiative($pClass)
        {
            //$this->database();
            if($pClass === "SR_Controller")
            {
                $this->_SR =& get_instance();
            }
            if($pClass === "SR_Model")
            {
                $this->_SR =& get_instance_model();
            }
        }

        public function database( $setDB = "default" )
        {
            if(!is_file( APPPATH . "../system/core/Database.php" ))
            {
                exceptionPack("database class not found");//抛出一个异常信息；
                exit;
            }
            require_once( APPPATH . "../system/core/Database.php" );
            return new DB($setDB);
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
                $name = new $helperFileName;
                $this->_SR->$helperFileName = $name;
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
                $this->_SR->$modelFileName = $name;
            }
        }






    }