<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function  __construct() {
        parent::__construct();

        $accessControlObj = new Accesscontrol_helper();
		$accessControlObj->is_logged_in();
    }

	function index()
	{
		$data['title'] = "Digime SMS System";
		$data['current_nav']='nav1';
		$data['page']='dashboard';
		$this->load->view("home",$data);
	}
}
