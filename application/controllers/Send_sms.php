<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_sms extends CI_Controller {

	function  __construct() {
        parent::__construct();
    }

    function index(){
        redirect('404');
    }

    function checkin(){
        // Write Log
        $log_message = 'Checkin Request - IP ('.$this->input->ip_address().') - ';

        if($_POST){
            $log_message .= 'POST - '.json_encode($_POST).' - ';
        }
        if($_GET){
            $log_message .= 'GET - '.json_encode($_GET).' - ';
        }
        if($_REQUEST){
            $log_message .= 'REQUEST - '.json_encode($_REQUEST).' - ';
        }

        $write_log = $this->mod_information->write_user_log('timelog', $log_message);

        if(isset($_POST)){
            $res = $this->mod_information->client_details_update('checkin');
            echo $res;
        }
        else{
            echo 'Not POST';
        }
    }// END checkin

    function checkout(){
        $gid = trim($this->input->get('guest_id'));

        // Write Log
        $log_message = 'Checkout Request - IP ('.$this->input->ip_address().') - GIID = '.$gid.' - ';
        $write_log = $this->mod_information->write_user_log('timelog', $log_message);

        if($gid != ''){
            $client_details = $this->mod_information->client_details_by_gid($gid);
            $ci_id = $client_details['ci_id'];

            $res = $this->mod_information->client_details_update('checkout', $ci_id);
            echo $res;
        }
        else{
            echo 'Not POST';
        }
    }// END checkout

	function birthday(){
        $gid = trim($this->input->get('guest_id'));
        
        // Write Log
        $log_message = 'Birthday Message Request - IP ('.$this->input->ip_address().') - GIID = '.$gid.' - ';
        $write_log = $this->mod_information->write_user_log('timelog', $log_message);

        if($gid != ''){
            $client_details = $this->mod_information->client_details_by_gid($gid);
            $ci_id = $client_details['ci_id'];

            $res = $this->mod_information->client_details_update('birthday', $ci_id);
            echo $res;
        }
        else{
            echo 'Not POST';
        }
	}// END birthday
}
