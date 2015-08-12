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
		echo 14;exit;
	}



}

