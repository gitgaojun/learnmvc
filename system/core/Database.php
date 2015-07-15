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
            }
            if(!isset($data))
            {
                return array();
            }
            if(count($data) == 1 )
            {
                return $data[0];
            }
            return $data;
        }

        /**
         * 插入数据
         * @param $sql
         * @return bool|mysqli_result
         */
        public function into($sql)
        {
            $result = mysqli_query( $this->link , $sql ) or die("Could not query:".mysqli_errno($this->link));
            return $result;
        }

        /**
         * 插入数据,给的数据是数组和一个表名
         * @author jun
         * @access public
         * @param array $data 插入的数据数组      array('column'=>'value',
         *                                              .........
         *                                          )
         * @param sting $table 表名
         * return false|int    正确返回插入的主键号码，错误返回false
         */
        public function insert( $data , $table )
        {
            $keys = array_keys($data);

            $keys_str = implode(',',$keys);
            $vals = array_values($data);
            $vals_str = implode(',', $vals );
            $sql = 'insert into ' . $table . ' ('.$keys_str.') value ( '.$vals_str.' )';
            var_dump($sql);exit;
            $result = $this->query($sql);
            var_export($result);exit;

        }

        /**
         * 销毁数据库连接
         */
        public function __destruct()
        {
            mysqli_close($this->link);
        }

    }

