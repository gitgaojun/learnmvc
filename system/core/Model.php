<?php
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/5/7
 * Time: 18:33
 */

    class SR_Model
    {
        private static $instance;
        function __construct()
        {
            self::$instance =& $this;
            require_once('Loader.php');
            //用来判断引用哪个类
            $pClass = __CLASS__;
            $this->load = new Loader($pClass);
        }

        public static function &get_instance_model()
        {
            return self::$instance;
        }
    }