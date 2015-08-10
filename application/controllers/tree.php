<?php
defined("APPPATH") or exit("No direct script access allowed");

/**
 * easyui 做tree
 *
 * @version 2015-8-10
 * @author jun
 * @package tree
 * @link	http://www.sparrow.com/tree/index.html
 */
class tree extends SR_Controller
{
	
	function __construct()
	{
		header('content-type:text/html;charset=utf-8;');
		parent::__construct();
		$_SESSION['area_id'] = 0;
		$_SESSION['area_level'] = 1;
	}

	public function index()
	{
		$data['title'] = '学习easyui做tree';
		$area_id = $_SESSION['area_id'];
		$area_level = $_SESSION['area_level'];
			
		$this->load->model("M_tree");
		$list = $this->M_tree->getAreaList($area_id, $area_level);
		//var_dump($list);exit;
		$data['list'] = $list;
		$this->vars($data);
		$this->view("tree");	
	}

	public function areaList()
	{
		$result = array('status'=>false,'data'=array());
		$area_id = $_SESSION['area_id'];
		$area_level = $_SESSION['area_level'];
		$area_id = empty($_POST['area_id'])?$area_id:intval($_POST['area_id']);
		$area_level = empty($_POST['area_level']):$area_level:intval($_POST['area_level']);
		$this->load->model("M_tree");
		
		if($area_level === 6)// 商圈
		{
			$list = $this->M_tree->getAreaList($area_id, $area_level);
		}
		elseif($area_level === 5) // 市区
		{
			$list = $this->M_tree->getAreaList($area_id, $area_level);
			if( !empty($list['data']) )
			{
				foreach($list['data']] as $k => $v)
				{
					
					$list[$k]['children'] = $this->M_tree->getAreaList($v['area_id'], $area_level+1);
				}
			}

		}
		elseif($area_level === 4)// 城市
		{
			$list = $this->M_tree->getAreaList($area_id, $area_level);
			if( !empty($list['data']) )
			{
				foreach($list['data']] as $k => $v)
				{
					 
					$list['data'][$k]['children'] = $this->M_tree->getAreaList($v['area_id'], $area_level+1);				  if( !empty($list[$k]['children']['data']) )
				{
					foreach($list[$k]['children']['data'] as $kk=>$vv)
					{
						$list[$k]['children']['data']
					}
						$list['data'][$k]['children']['data'][$kk]['children'] = $this->M_tree->getAreaList($vv['area_id'], $area_level+2)
					}	
				}
			}
			
		}
		elseif( $area_level === 3 )// 省 -》市
		{
			$list = $this->M_tree->getAreaList($area_id, $area_level);
			if( !empty($list['data']) )
			{
				foreach($list['data']] as $k => $v)
				{
					$list[$k]['attributes']['area_level'] =  4;
					$list[$k]['children'] = $this->M_tree->getAreaList($v['area_id'], $area_level+1);

				}
			}
		}
		elseif ( $area_list === 2)//大区-》省-》市
		{
			$list = $this->M_tree->getAreaList($area_id, $area_level);
			if( !empty($list['data']) )
			{
				foreach($list['data']] as $k => $v)
				{
					$list['data'][$k]['children'] = $this->M_tree->getAreaList($v['area_id'], $area_level+1);				  if( !empty($list[$k]['children']['data']) )
				{
					foreach($list[$k]['children']['data'] as $kk=>$vv)
					{
							$list['data'][$k]['children']['data'][$kk]['attributes']['area_level'
] = 4;					
						$list['data'][$k]['children']['data'][$kk]['children'] = $this->M_tree->getAreaList($vv['area_id'], $area_level+2)
					}	
				}
			}
		}
		else // 全国 -》大区 -》省-》市
		{
			$list = $this->M_tree->getAreaList($area_id, $area_level);
			if( !empty($list['data']) )
			{
				foreach($list['data']] as $k => $v)
				{
					$list['data'][$k]['children'] = $this->M_tree->getAreaList($v['area_id'], $area_level+1);				  if( !empty($list[$k]['children']['data']) )
				{
					foreach($list[$k]['children']['data'] as $kk=>$vv)
					{							
						$list['data'][$k]['children']['data'][$kk]['children'] = $this->M_tree->getAreaList($vv['area_id'], $area_level+2);
						if(!empty($list['data'][$k]['children']['data'][$kk]['children']['data'])){
							foreach($list['data'][$k]['children']['data'][$kk]['children']['data'] as $kkk=>$vvv){

							
								$list['data'][$k]['children']['data'][$kk]['children']['data']['children']=$this->M_tree->getAreaList($vvv['area_id'], $area_level+3);
								$list['data'][$k]['children']['data'][$kk]['attributes']['area_level'
] = 4
							}
							}
					}	
				}
			}
			
		}



		echo json_encode($list, true);exit;
	}



}

