<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_user extends CI_Controller {

	function  __construct() {
        parent::__construct();

        $accessControlObj = new Accesscontrol_helper();
		$accessControlObj->is_logged_in();
    }

	function index()
	{
        $data['message'] = trim($this->uri->segment(3));

        $data['system_users'] = $this->mod_user_access->system_user_view_all();

		$data['title'] = "Digime SMS System | View All System User";
		$data['current_nav']='nav4';
		$data['page']='system-user-view-all';
		$this->load->view("home",$data);
	}

	function add_edit(){
        $su_id = trim($this->uri->segment(3));
        $user_details = false;
        if($su_id){
            $user_details = $this->mod_user_access->system_user_details($su_id);
            if (!$user_details) {
            	echo 'Invalid Request.'; exit();
            }
        }// END IF
		$data['user_details'] = $user_details;

        $data['user_types'] = $this->mod_user_access->system_user_type_view_all();


        if($this->input->post('submit')){
        	// print_r($_POST); exit();
            $add_edit = $this->mod_user_access->system_user_add_edit($su_id);

            if($add_edit===true) {
            	if($user_details){ redirect('system-user/message/updated'); }
            	else{ redirect('system-user/message/added'); }                
            }
            else{
                $data['message'] = $add_edit;
            }
        }

		$data['title'] = "Digime SMS System | Add System User";
		$data['current_nav']='nav4';
		$data['page']='system-user-add-edit';
		$this->load->view("home", $data);
	}// END add_edit
}
