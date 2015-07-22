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

        /**
         * 查询语句
         * @param $sql
         * @return array
         */
        public function query($sql)
        {
            $result = $this->_query($sql);
            $data = array();
            if( is_object($result) )
            {
                while($row = $result->fetch_assoc())
                {
                    $data[] = $row;
                }
            }
            return $data;
        }

        /**
         * 对接数据库，执行发送sql语句来操作数据库
         * @author jun
         * @access private
         * @param sting $sql
         * @return bool
         */
        private function _query($sql)
        {
            $result = mysqli_query($this->link, $sql) or die("Could not query:".mysqli_errno($this->link));
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
         * @param array $wdata 条件数组          array('column'=>'value',
         *                                              .........
         *                                          )
         * @return false|int    正确返回插入的主键号码，错误返回false
         */
        public function autoInsert( $data , $table , $wdata=array())
        {
            $field = '';
            $vdata = '';
            $wlist = '';
            while(list( $k , $v ) = each($data))
            {
                if(empty($field))
                {
                    $field .= '`'.$k.'`';
                    $vdata .= '"'.$v.'"';
                }
                else
                {
                    $field .= ',`'.$k.'`';
                    $vdata .= ',"'.$v.'"';
                }
            }
            while ( list($wk, $wv) = each($wdata) )
            {
                if ( empty($wlist) )
                {
                    $wlist .= ' where '.$wk.'="'.$wv.'" ';
                }
                else
                {
                    $wlist .= ' and '.$wk.'="'.$wv.'"';
                }
            }
            $sql = 'insert into ' . $table . ' (' . $field . ') value (' . $vdata . ')' . $wlist;
            $result = $this->_query( $sql );
            if($result)
            {
                $result = mysqli_insert_id($this->link);
            }
            return $result;
        }

        /**
		 * 删除数据
		 * @author jun
		 * @access public
         * @param string $table 表名
         * @param array $data
         * @explam                  array('l_name' => 'jun'
         *                                  ......
         *
         *                          )
         * @return bool
         */
        public function delete( $table , $data )
        {
            $wdata = '';
            while( list($column,$value) = each($data) )
            {
                if(empty($wdata))
                {
                    $wdata .= '`' . $column . '`="' . addslashes($value) . '" ';
                }
                else
                {
                    $wdata .= 'and `' . $column . '`="' . addslashes($value) . '" ';
                }
            }
            $sql = 'delete from ' . $table . ' where ' . $wdata;
            $result = $this->_query( $sql );
            return $result;
        }

        /**
         * 更新数据
         * @author jun
         * @access public
         * @param string $table 表名
         * @param array $data           array('l_name' => 'jun' , .... );
         * @param array $wdata          array('l_name' => 'jun' , .... );
         * @return bool
         */
        public function update($table , $data , $wdata)
        {
            $set_data = '';
            $w_data = '';
            while( list($sk,$sv) = each($data) )
            {
                if(is_array($sv))
                { //用来给字段自增或者自减,计数用
                    list($svk, $svv) = each($sv);
                    if($sk === $svk)
                    {
                        $sv = '`'.$svk.'`'.$svv;
                    }
                }
                else
                {
                    $sv = '"'.$sv.'"';
                }
                if(empty($set_data))
                {
                    $set_data .= '`' . $sk . '`=' . $sv . ' ';
                }
                else
                {
                    $set_data .= ', `' . $sk . '`=' . $sv . ' ';
                }
            }
            while( list($wk, $wv) = each($wdata) )
            {
                if(empty($w_data))
                {
                    $w_data .= '`' . $wk . '`="' . $wv . '" ';
                }
                else
                {
                    $w_data .= 'and`' . $wk . '`="' . $wv . '" ';
                }
            }
            $sql = 'update ' . $table . ' set ' . $set_data . ' where ' . $w_data;
            $result = $this->_query( $sql );
            return $result;
        }


        /**
         * 得到一个栏目的值
         * @param sting $field column名字
         * @param string $table 表名
         * @param array $data   数字
         * @return bool|int
         */
        public function getColumnValue($field, $table, $data)
        {
            $wdata = '';
            while ( list($k, $v) = each($data) )
            {
                if(empty($wdata))
                {
                    $wdata .= 'where `'.$k.'`="'.$v.'" ';
                }
                else
                {
                    $wdata .= 'and `'.$k.'`="'.$v.'" ';
                }
            }
            $sql = 'select '.$field.' from '.$table.' '.$wdata;
            $fieldValue = $this->_query($sql);
            if(empty($fieldValue)) $result=false;
            else                   $result=$fieldValue[0][$field];
            return $result;
        }


        /**
         * 销毁数据库连接
         */
        public function __destruct()
        {
            mysqli_close($this->link);
        }

    }

