<?php
defined("APPPATH") or exit("No direct script access allowed");


/**
 * 测试jquery 封装的表单验证对象是否好用
 *
 * @since 2015-8-12
 * @author jun
 * @package form
 * @link		http://www.sparrow.com/form/index.html
 */
class form extends SR_Controller
{

	function __construct()
	{
		header('content-type:text/html;charset=utf-8;');
		parent::__construct();
	}

	/**
	 * 测试页面
	 *
	 * @since 2015-8-12
	 * @author jun
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$data['title'] = 'from表单页面';
		$this->vars($data);
		$this->view("form");
	}

	/**
	 * 测试jquery控制checkbox 权限页面
	 *
	 * @since 2015-8-31
	 * @author jun
	 * @access public
	 * @return void
	 */
	public function checkbox()
	{
		$this->view("checkbox");
	}

}
