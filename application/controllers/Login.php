<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends  CI_Controller {

    function  __construct() {
        parent::__construct();
    }
    
	function index()
	{
		$data['message']='';		
		if($_POST){
			$result=$this -> mod_user_access -> get_login_info();

			if($result==TRUE){
				redirect('dashboard');
			}
			else{
				$data['message']='invalid';				
			}
		}

		$data['title'] = "Admin"; // Capitalize the first letter			
		$data['current_nav']='';
		$data['page']='login';
		$data['single_page']=1;
		$this->load->view("home",$data);

    }// index() END

}
