<?php
defined("APPPATH") OR exit("No direct script access allowed");
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/5/14
 * Time: 9:17
 */

    class DB
    {
        private $set = array();//数据库的配置信息
        private $link;
        function __construct($db = "default")
        {
            if(!is_file( APPPATH . "../application/config/database.php" ))
            {
                exceptionPack("config/database.php is not exist");
            }
            require_once( APPPATH . "../application/config/database.php" );
            $this->set = $database[$db];//数据库的配置数组
            $this->initiative();
        }

        /**
         * 初始化数据库连接
         */
        private function initiative()
        {
            $_dbConfig = $this->set;
            //利用@屏蔽掉 建议使用mysqli或者pdo的建议
            $this->link = mysqli_connect($_dbConfig['host'], $_dbConfig['user'], $_dbConfig['pwd'], $_dbConfig['database'])
                            or die("mysql error:" . mysqli_connect_error());
            if (!$this->link)
            {
                die('Could not connect:' . mysql_error());
            }
            mysqli_query( $this->link, "SET NAMES 'utf8'");
        }

        public function query($sql)
        {
            $result = mysqli_query( $this->link , $sql ) or die("Could not query:".mysqli_errno($this->link));
            if( $result )
            {
                while($row = $result->fetch_assoc())
                {
                    $data[] = $row;
                }
                if($row==null)
                {
                    return array();
                }
            }
            if(count($data) == 1 )
            {
                return $data[0];
            }
            return $data;
        }

        /**
         * 销毁数据库连接
         */
        public function __destruct()
        {
            mysqli_close($this->link);
        }

    }

