<?php
defined("APPPATH") or exit("No direct script access allowed");
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/7/23
 * Time: 10:59
 */

    class area extends SR_Controller
    {
        function __construct()
        {
            parent::__construct();
        }

        /**
         * 更新省信息
         */
        public function index()
        {
            $page = empty($_GET['attr'])?"":addslashes(trim($_GET['attr']));
            if( $page!=='province' )
            {
                exit('404 page');
            }
            $this->load->model('M_area');
            $update_province_list = $this->M_area->updateProvinceList();
            if($update_province_list['status'])
            {
                $data['msg'] = '插入省信息成功';
            }
            else
            {
                $data['msg'] = '插入省信息失败';
            }
            $this->vars($data);
            $this->view("province");
        }

        /**
         * 更新市信息
         */
        public function updateCity()
        {
            $page = empty($_GET['attr'])?"":addslashes(trim($_GET['attr']));
            if( $page!=='city' )
            {
                exit('404 page');
            }
            $this->load->model('M_area');
            $update_city_list = $this->M_area->updateCityList();
            if($update_city_list['status'])
            {
                $data['msg'] = '插入城市信息成功';
            }
            else
            {
                $data['msg'] = '插入城市信息失败';
            }
            $this->vars($data);
            $this->view("province");
        }

        /**
         * 更新区域信息
         */
        public function updateRegional()
        {
            $page = empty($_GET['attr'])?"":addslashes(trim($_GET['attr']));

            if( $page!=='regional' )
            {
                exit('404 page');
            }
            $this->load->model('M_area');
            $update_regional_list = $this->M_area->updateRegionalList();
            if($update_regional_list['status'])
            {
                $data['msg'] = '插入区域信息成功';
            }
            else
            {
                $data['msg'] = '插入区域信息失败';
            }
            $this->vars($data);
            $this->view("province");
        }

        /**
         * @author jun
         * @time 2015-7-28
         * 更新商圈信息
         */
        public function updateDistrict()
        {
            $page = empty($_GET['attr'])?"":addslashes(trim($_GET['attr']));
            if( $page!=='district' )
            {
                exit('404 page');
            }
            $this->load->model('M_area');//echo 3;exit;
            $update_District_list = $this->M_area->updateDistrictList();

            if($update_District_list['status'])
            {
                $data['msg'] = '插入商圈信息成功';
            }
            else
            {
                $data['msg'] = '插入商圈信息失败';
            }
            $this->vars($data);
            $this->view("province");
        }

    }