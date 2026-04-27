<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Joint extends MY_Controller
{
    public $module = 'joint';

    function __construct() {
        parent::__construct();
    }

    function index() {
        $module = $this->module;
        $data['module'] = $module;
        $data['title']  = 'Joint';
        $data['sub_title'] = "Master";
		$data['sub']	= "Joint";
        $page = $module.'/v_index';
        $js = $module.'/js_index';
        echo modules::run('template/loadview', $data, $page, $js);
    }
    
    
}