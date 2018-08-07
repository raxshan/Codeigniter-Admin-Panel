<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Accesscontrol_helper{
    
    function is_logged_in(){

        $CI =& get_instance();
        $ses_digime = $CI->session->userdata('ses_digime');
        $is_logged_in = $ses_digime['is_logged_in'];
        if($is_logged_in != true){            
            redirect('login'); 
        }
    }// END function is_logged_in()
    
}// END class Accesscontrol_helper