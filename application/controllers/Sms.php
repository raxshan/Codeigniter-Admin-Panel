<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {

	function  __construct() {
        parent::__construct();

        $accessControlObj = new Accesscontrol_helper();
		$accessControlObj->is_logged_in();
    }

	function index()
	{
         $data['message'] = trim($this->uri->segment(3));

        if(isset($_POST['update'])){
            $update_sms_details = $this->mod_information->update_sms_details();

            if($update_sms_details=='updated') {
                redirect('sms/message/updated');
            }
            else{
                $data['message']=$update_sms_details;
            }
        }

        $data['checkin_sms'] = $this->mod_information->sms_details('checkin');
        $data['checkout_sms'] = $this->mod_information->sms_details('checkout');
        $data['birthday_sms'] = $this->mod_information->sms_details('birthday');

		$data['title'] = "Digime SMS System | View SMS body";
		$data['current_nav']='nav2';
		$data['page']='sms-view';
		$this->load->view("home",$data);
	}
}
