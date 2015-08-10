<?php
defined("APPPATH") or exit("No direct script access allowed");

/**
 * class M_tree
 * 城市数据
 *
 * @since 2015-8-10
 * @author jun
 * @package M_tree
 *
 */
class M_tree extends SR_Model
{

	function __construct()
	{
		parent::__construct();
		$this->_db = $this->load->database("sparrow");
	}

	/**
	 * 获取地址信息
	 *
	 * @since 2015-8-10
	 * @author jun
	 * @access public
	 * @param int $area_id 区域id
	 * @param int $area_level 区域等级
	 * @return array
	 */
	public function getAreaList($area_id, $area_level)
	{
			
        $result = array("status"=>false, "code"=>10000, "msg"=>"", "data"=>array());
		$sql = 'select * from s_area where p_id="'.$area_id.'"';
		//echo $sql;exit;
		$list = $this->_db->query($sql);
		if( !empty($list) )
		{
			$result['status'] = true;
			$result['data'] = $list;
		}
		return $result;
	}	
}	
