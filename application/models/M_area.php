<?php
defined("APPPATH") or exit("No direct script access allowed");
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/7/23
 * Time: 11:09
 */

    /**
     * Class M_area
     * 更新city数据
     *
     * @since 2015-8-3
     * @author jun
     * @package M_area
     */
    class M_area extends SR_Model
    {

        protected $area_list;//地区列表

        function __construct()
		{
			header('content-type:text/html; charset=utf-8;');
            parent::__construct();
            $this->_db = $this->load->database("sparrow");
			$area_list = file_get_contents(APPPATH.'../data/content.json');
			//var_dump(json_decode($area_list, true));
			//exit;
            $this->area_list = json_decode($area_list,true);
        }

        /**
         * 更新省数据表信息
         *
         * @since 2015-8-3
         * @access public
         * @author jun
         * @return array
         */
        public function updateProvinceList()
        {
            $result = array("status"=>false, "code"=>10000, "msg"=>"", "data"=>array());
            $province_list = array();
            #################筛选出省信息############################################################################
			$is_status = 1;
			//var_dump($this->area_list['def']);exit;
            foreach( $this->area_list['def'] as $k => $v )
            {
                if( intval($k) > 1 )
                {
                    $province_list = array('p_code'=>intval($k),'p_name'=>$v);
                    $result['status'] = $this->_db->autoInsert($province_list, 's_province');
                    if( !$result['status'] )
                    {
                        $is_status = 0;
                    }
                }
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////

            if( $is_status )
            {
                $result['status'] = true;
            }
            return $result;
		}

		/**
		 * 更新大区信息
         *
         * @since 2015-8-3
		 * @access public
		 * @author jun
		 * @return array
		 */
		public function updateLCityList()
		{	
			// 发现城市表中有大区的分类信息，该方法无用	
            $result = array("status"=>false, "code"=>10000, "msg"=>"", "data"=>array());

            require_once('../application/helpers/Snoopy.class.php');
            $snoopy = new Snoopy;
            $submit_url = 'http://www.dianping.com';
			$snoopy->referer = "http://www.baidu.com";
			$snoopy->rawheaders["COOKIE"] = "cye=shenzhen;";
			$snoopy->rawheaders['X_FORWARDED_FOR'] = '127.0.0.1';
			$snoopy->fetch("$submit_url");//获取发贴页面
			$regex = "/class=\"city-list J-city-list Hide\".*?>.*?all/ism";
			$html_list = $snoopy->results;
			preg_match_all($regex ,$html_list, $list);
			$list = $list[0][0];
			$regex1 = "/class=\"group clearfix.*?\">.*?<\/div>/ism";
			preg_match_all($regex1, $list, $list1);
			foreach( $list1[0] as $k => $v )
			{
				$regex2 = "/class=\"title\".*?>(.*?)(：)<\/h3>/ism";
				preg_match_all( $regex2, $v, $list2 );// $list2[1][0]="华北东北"
				$regex3 = "/<a.*?href=\".*?\".*?>(.*?)<\/a>/ism";
				preg_match_all( $regex3, $v, $list3 );// $list3[1][0]="北京"
				//var_dump( $v,  $list3);exit;
				
			}exit;
			var_dump($list1);exit;
		}
		

        /**
         * 更新市数据表信息
         *
         * @since 2015-8-3
         * @access public
         * @author jun
         * @return array
         */
        public function updateCityList()
        {
            $result = array("status"=>false, "code"=>10000, "msg"=>"", "data"=>array());
            #################筛选出城市信息 cityList #######################################################
            $is_status = 1;
            $city_list = $this->area_list['link'];
            $city_info = $this->area_list['def'];
            $cityList = array();
            foreach( $city_list as $lk => $lv)
            {
                foreach( $city_info as $ik => $iv)
                {
                    if( is_array($lv) )
                    {
                        foreach( $lv as $llk=>$llv )
                        {
                            if($llv===$ik)
							{
                                $cityList = array(
                                    'c_parent_id'   =>  $lk,
                                    'c_name'        =>  $iv,
                                    'c_info'        =>  $llv
                                );
                                $result['status'] = $this->_db->autoInsert($cityList, 's_city');
                                if( !$result['status'] )
                                {
                                    $is_status = 0;
                                }
                            }

                        }
                    }
                }
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////////////

            if( $is_status )
            {
                $result['status'] = true;
            }
            return $result;
        }

        /**
         * 更新区信息
         *
         * @since 2015-8-3
         * @author jun
         * @access public
         * @return array
         */
        public function updateRegionalList()
        {
            $result = array("status"=>false, "code"=>10000, "msg"=>"", "data"=>array());
            $city_list = $this->_db->query('select * from s_city where c_id>608');
            $is_status = 1;
            foreach( $city_list as $k => $v )
            {
                if( is_array($v) )
                {
                    $list = $this->getRegionalList($v);
                    #######################插入区域数据########################################################
                    if( !empty($list) )
                    {
                        foreach( $list as $lk => $lv )
                        {
                            $regionalList = array(
                                'r_parent_id'   =>  $v['c_id'],
                                'r_name'        =>  $lv,
                                'r_info'        =>  $lk
                            );
                            $result['status'] = $this->_db->autoInsert($regionalList, 's_regional');
                            if( !$result['status'] )
                            {
                                $is_status = 0;
                            }
                        }
                    }
                    ///////////////////////////////////////////////////////////////////////////////////
                }
            }
            if( $is_status )
            {
                $result['status'] = true;
            }
            return $result;
        }


        /**
         * 获取数据
         *
         * @since 2015-8-3
         * @author jun
         * @access protected
         * @param array $data city信息    array('c_id'=>1,'c_name'=>'bj');
         * @return array
         */
        protected function getRegionalList($data)
        {
            //防止超时，php.ini  max_execution_time = 0 永久不过期
            //sleep(60);
            $result = array();
            $list = array();
            $regional_info = array();
            $regional_name = array();
            $url = 'http://'.$data['c_info'].'.meituan.com/category/';
			//$content_file =file_get_contents($url);
			$content_file = $this->getContent($url,intval($data['c_id']+56));
			//var_dump($content_file);exit; // 2分钟接连请求就被判断为恶意请求	
            $regex = "/<ul class=\"inline-block-list J-filter-list filter-list--fold\".*?>.*?<\/ul>/ism";
            preg_match_all($regex, $content_file, $list);
            if( !empty($list[0][0]) )
            {
                // $regex2 = "/[\x{4e00}-\x{9fa5}]+/u";  // 有时候会用 / 来命名  新田广场/世纪广场  -  时代广场-步行街     银座/百货大楼/佳乐 水城县（滥坝镇）
                $regex2 = "/([\x{4e00}-\x{9fa5}]+[（]+[\x{4e00}-\x{9fa5}]+[）]+)|([\x{4e00}-\x{9fa5}]+\/[\x{4e00}-\x{9fa5}]+\/[\x{4e00}-\x{9fa5}]+)|([\x{4e00}-\x{9fa5}]+\/[\x{4e00}-\x{9fa5}]+)|([\x{4e00}-\x{9fa5}]+\-[\x{4e00}-\x{9fa5}]+)|([\x{4e00}-\x{9fa5}]+)/u";
                preg_match_all($regex2, $list[0][0], $regional_info);
                $regex3 = "/\/([a-zA-Z0-9]+)\">/u";     // 有时候重名的会需要数字结合起来命名
                preg_match_all($regex3, $list[0][0], $regional_name);
                ################销毁掉全部 和 地铁附近###############################################
                foreach( $regional_info[0] as $k => $v )
                {
                    if( in_array($v, array('全部', '地铁附近')))
                    {
                        unset($regional_info[0][$k]);
                    }
                }
                foreach( $regional_name[1] as $rk => $rv )
                {
                    if( in_array($rv, array('subway')) )
                    {
                        unset($regional_name[1][$rk]);
                    }
                }
                ///////////////////////////////////////////////////////////////////////////////////
                if( !empty($regional_name[1]) && !empty($regional_info[0]))
                {
                    if( count($regional_name[1]) !== count($regional_info[0]) )
                    {
                        var_dump($url);
                        echo "<hr>";
                        var_dump($regional_name);
                        echo "<hr>";
                        var_dump($regional_info);
                        exit;
                    }
                    $result = array_combine($regional_name[1], $regional_info[0]);
                }
                else
                {
                    $result = array();
                }
            }
            return $result;
        }

        /**
         * 更新 商圈 的信息
         *
         * @since 2015-8-3
         * @author jun
         * @access public
         * @param int $c_num 城市id
         * @return array
         */
        public function updateDistrictList($c_num)
        {
            $result = array("status"=>false, "code"=>10000, "msg"=>"", "data"=>array());
            //$city_list = $this->_db->query('select * from s_city where c_id=16');

            $city_list = $this->_db->query('select * from s_city where c_id="'.$c_num.'"');
            $is_status = 1;
            foreach( $city_list as $k => $v )
            {
                if( is_array($v) )
                {
                    //var_dump($v);exit;
                    // 查询出城市和区域的信息，用于去找商圈的信息  http://sz.meituan.com/category/all/nanshanqu
                    $regList = $this->_db->query('select * from s_city as c inner join s_regional as r on r.r_parent_id=c.c_id where c.c_id="'.$v['c_id'].'"');
                    foreach( $regList as $rk => $rv )
                    {
                        // var_dump($rv);exit;
                        $list = $this->getDistrictList($rv, rand(1,9999));
                         //var_dump($list);exit;

                        #######################插入区域数据########################################################
                        if( !empty($list) )
                        {
                            foreach( $list as $lk => $lv )
							{
								
                                $districtList = array(
                                    'd_parent_id'   =>  $rv['r_id'],
                                    'd_name'        =>  $lv,
                                    'd_info'        =>  $lk
                                );
								//var_dump($districtList);exit;
                                $result['status'] = $this->_db->autoInsert($districtList, 's_district');
                                if( !$result['status'] )
                                {
                                    $is_status = 0;
                                }
                            }
                        }
                        ///////////////////////////////////////////////////////////////////////////////////
                    }

                }
            }
            if( $is_status )
            {
                $result['status'] = true;
            }
            return $result;
        }

        /**
         * 得到商圈信息
         *
         * @since 2015-8-3
         * @author jun
         * @access protected
         * @param $data
         * @param int $uuid 次数
         * @return array
         */
        protected function getDistrictList($data, $uuid)
        {
            //防止超时，php.ini  max_execution_time = 0 永久不过期
            // http://sz.meituan.com/category/all/nanshanqu
            //sleep(3);
            // echo 3;exit;
            $result = array();
            $list = array();
            $district_info = array();
            $district_name = array();
			$url = 'http://'.$data['c_info'].'.meituan.com/category/all/'.$data['r_info'];
			//var_dump($url);exit;
            //$content_file =file_get_contents($url);   //长时间访问会被封ip 现在换其他方式
            ###############突破访问次数过多被限制的情况##############################################################
            $content_file = $this->getContent($url, $uuid);
			echo $url;
			//var_dump($content_file);exit;
            //////////////////////////////////////////////////////////////////////////////////////////////////////
            $regex = "/class=\"sub-filter-wrapper sub-filter-wrapper--geo.*?\".*?>.*?<\/ul>/ism";
            preg_match_all($regex, $content_file, $list);
			//var_dump($list);exit;
			if( !empty($list[0][0]) )
            {
                // $regex2 = "/[\x{4e00}-\x{9fa5}]+/u";  // 有时候会用 / 来命名  新田广场/世纪广场  -  时代广场-步行街     银座/百货大楼/佳乐 水城县（滥坝镇）丝联166创意园
                // $regex2 = "/([\x{4e00}-\x{9fa5}]+[0-9]+[\x{4e00}-\x{9fa5}]+)|([\x{4e00}-\x{9fa5}]+[（]+[\x{4e00}-\x{9fa5}]+[）]+)|([\x{4e00}-\x{9fa5}]+\/[\x{4e00}-\x{9fa5}]+\/[\x{4e00}-\x{9fa5}]+)|([\x{4e00}-\x{9fa5}]+\/[\x{4e00}-\x{9fa5}]+)|([\x{4e00}-\x{9fa5}]+\-[\x{4e00}-\x{9fa5}]+)|([\x{4e00}-\x{9fa5}]+)/u";
                $regex2 = "/<a href=\".*?\".*?>(.*?)<\/a>/ism";
                preg_match_all($regex2, $list[0][0], $district_info);// $district_info[1] 是想要的
                $regex3 = "/all\/([a-zA-Z0-9]+)\"/u";     // 有时候重名的会需要数字结合起来命名
                // var_dump($district_info);exit;
                preg_match_all($regex3, $list[0][0], $district_name);
                //var_dump($district_info, $district_name);exit;
                ################销毁掉全部 和 地铁附近###############################################
                foreach( $district_info[1] as $k => $v )
                {
                    if( in_array($v, array('全部商圈')))
                    {
                        unset($district_info[1][$k]);
                    }
                }
                foreach( $district_name[1] as $rk => $rv )
                {
                    if( in_array($rv, array($data['r_info'])) )
                    {
                        unset($district_name[1][$rk]);
                    }
                }
                //var_dump($district_name, $district_info);exit;
                ///////////////////////////////////////////////////////////////////////////////////
                if( !empty($district_name[1]) && !empty($district_info[1]))
                {
                    if( count($district_name[1]) !== count($district_info[1]) )
                    {
                        var_dump($url);
                        echo "<hr>";
                        var_dump($district_name);
                        echo "<hr>";
                        var_dump($district_info);
                        exit;
                    }
                    $result = array_combine($district_name[1], $district_info[1]);
                }
                else
                {
                    $result = array();
                }
            }
            //var_dump($result);exit;
            return $result;
        }

        /**
         * 抓取页面信息
         * agent cookie 来做的限制是否跳转提示用户操作频繁
         *
         * @since 2015-8-3
         * @author jun
         * @access protected
         * @param string $url  要访问的地址
         * @param int $uuid    id值用于动态改变模拟的访问信息来源
         * @return string      包含网页信息的字符串
         */
        protected function getContent($url, $uuid)
		{
			static $num=1;
            require_once('../application/helpers/Snoopy.class.php');
            $snoopy = new Snoopy;
            $submit_url = $url;
            //$snoopy->agent = "Mozilla/6.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.2357.124 Safari/537.36";
			++$num;
			//var_dump(round(300/200));exit;
			$chrome_size = round($num/200)!==0?intval(round($num/200)):1;
			//var_dump($chrome_size);
			$snoopy->agent = "Mozilla/".
				$chrome_size.".0 (Windows NT 6.1; WOW64) AppleWebKit/".
				$chrome_size.".".
				$chrome_size." (KHTML, like Gecko) Chrome/".
				$chrome_size.".0.".
				rand(1,9999).".".
				$chrome_size." Safari/".
				$chrome_size.".36";
			$snoopy->referer = "http://www.baidu.com";
            // $snoopy->rawheaders["COOKIE"] = "uuid=f91d86f2b4966e182b17.1438248410.0.0.0;";
            // $uuid = $uuid+intval(00000000000000000000)
			$snoopy->rawheaders['X_FORWARDED_FOR'] = '127.0.0.1';
			$snoopy->rawheaders["COOKIE"] = "uuid=".$uuid.".".
				$chrome_size.".0.0.0;";
            $snoopy->fetch("$submit_url");//获取发贴页面
            $result = $snoopy->results;
            return $result;
        }

        /**
         * 获取动态ip地址
         *
         * @since 2015-8-3
         * @author jun
         * @access protected
         * @return string
         */
        protected function rand_ip()
        {
            $ip = mt_rand(10,254).'.'.mt_rand(10,254).'.'.mt_rand(10,254).'.'.mt_rand(10,254);
            return $ip;
        }

    }
