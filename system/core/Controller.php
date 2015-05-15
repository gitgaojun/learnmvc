<?php
defined("APPPATH") or exit("No direct script access allowed");

/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/4/22
 * Time: 14:02
 */

    //核心控制类
    class SR_Controller
    {
        protected $_data = array();//页面赋值的标量数组
        protected $_view = "";//视图的文件名
        private static $instance;

        function __construct()
        {
            self::$instance =& $this;
            require_once('Loader.php');
            //用来判断引用哪个类
            $pClass = __CLASS__;
            $this->load = new Loader($pClass);
        }

        public static function &get_instance()
        {
            return self::$instance;
        }

        /**
         * 页面赋值的变量数组
         * @param array $data 页面加载的数据，必须是关联数组，不能是有序数组
         * @return $this
         */
        public function vars( array $data)
        {
            $this->_data = $data;
            return $this;
        }

        /**
         * 视图文件名
         * @param $viewName string
         * @return $this
         */
        public function view( $viewName )
        {
            $this->_view = $viewName;
            return $this;
        }

        /**
         * 用来合成变量数组和视图
         * 利用ob缓存把数据整理起来
         */
        protected function compound()
        {
            if(!is_file(VPATH.$this->_view.EXT))
            {
                return;
            }
            ob_start();
            echo (str_replace( array("{", "}"), array("<?php ", "?>"), file_get_contents(VPATH.$this->_view.EXT)));
            $buffer = ob_get_contents();
            ob_clean();
            $cacheFile = md5($this->_view).EXT;
            if(!is_dir($dir=dirname(VPATH."../cache/".$cacheFile)))
            {
                mkdir($dir, 0755, true);
            }

            file_put_contents($dir."/".$cacheFile, $buffer, LOCK_EX);


            $this->display($cacheFile);
        }

        /**
         * 把缓存的静态文件读取出来
         * @param string $cacheFile 文件名
         */
        protected function display($cacheFile="")
        {
            //拆分数组
            extract($this->_data);
            include(VPATH."../cache/".$cacheFile);
        }

        /**
         * 销毁的时候调用合成页面
         */
        public function __destruct()
        {
            $this->compound();
        }






    }