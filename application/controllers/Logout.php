<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends  CI_Controller {

    function  __construct() {
        parent::__construct();
        $this -> load -> model('mod_user_access');
    }

    function index()
    {
		$logout = $this -> mod_user_access -> logout();
		redirect('login');
    }


}
?>