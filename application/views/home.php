<?php 
	/*
    if ($dir!='login' && !$this->session->userdata('is_logged_in')){ 
        redirect('login');
    }
	*/


	if(isset($single_page) && $single_page=='1'){
		$this->view('pages/'.$page);
	}
	else{
		$this->view('shared/header');
		
		$this->view('pages/'.$page);
		
		$this->view('shared/footer');	
	}
?>