<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Mod_user_access extends CI_model
	{
		public function __construct()
		{
	        parent::__construct();
		}

	    function system_user_view_all($sut_type_key = false){
	        $sql = "SELECT * FROM system_users, system_users_type WHERE system_users.sut_id = system_users_type.sut_id ";
	        if($sut_type_key){
	        	$sql .= " AND system_users_type.sut_type_key = '$sut_type_key' ";
	        }
	        $sql .= " ORDER BY system_users.su_id DESC";

	        $query=$this->db->query($sql);
	        if($query -> num_rows()>0){
	            $result = $query->result_array();
	            return $result;
	        }
	        else{
	        	return false;
	        }
	    }// END system_user_view_all

	    function system_user_details($su_id, $su_email = false, $req_type = false){
	        $sql = "SELECT * FROM system_users, system_users_type WHERE system_users.sut_id = system_users_type.sut_id ";

	        if($su_id){
	        	if($req_type=='not-this-id'){
	        		$sql .= " AND system_users.su_id != '$su_id' ";
	        	}
	        	else{
	        		$sql .= " AND system_users.su_id = '$su_id' ";	        		
	        	}
	        }
	        else if($su_email){
	        	$sql .= " AND system_users.su_email = '$su_email' ";
	        }
	        else{
	        	return false;
	        }

	        $sql .= " ORDER BY system_users.su_id DESC";

	        $query=$this->db->query($sql);
	        if($query -> num_rows()>0){
	            // $result = $query->result_array();
	            $result = $query->row_array();
	            return $result;
	        }
	        else{
	        	return false;
	        }
	    }// END system_user_details

	    function system_user_add_edit($su_id=false){
			$type = $this->input->post('type');
			$first_name = trim($this->input->post('first_name'));
			$last_name = trim($this->input->post('last_name'));
			$mobile = trim($this->input->post('mobile'));
			$email = trim($this->input->post('email'));
			if(!$email){ return 'Email Required'; }

			$status = $this->input->post('status');

			$user_details = $this->mod_user_access->system_user_details($su_id, $email, 'not-this-id');
			if($user_details){
				return 'This email address ('.$email.') already exist.';
			}

	        $user_type_details = $this->system_user_type($type);
	        if(!$user_type_details){
	        	return 'Invalid System User Type.';
	        }

            $data = array (
                'sut_id' => $type,
                'su_first_name' => $first_name,
                'su_last_name' => $last_name,
                'su_mobile' => $mobile,
                'su_email' => $email,
                'su_status' => $status
            );

        	if($su_id){
                $this->db->where('su_id', $su_id);
                $this->db->update('system_users', $data);  
        	}
        	else{
				$password = $this->input->post('password');
				if(!$password){ return 'Password Required'; }
        		$data['su_password'] = crypt($password);

        		$this->db->insert('system_users', $data);
            	$su_id = $this->db->insert_id();
        	}
            return true;
	    }// END system_user_add_edit

	    function system_user_type_view_all(){
	        $sql = "SELECT * FROM system_users_type ORDER BY sut_type ASC";

	        $query=$this->db->query($sql);
	        if($query -> num_rows()>0){
	            $result = $query->result_array();
	            return $result;
	        }
	        else{
	        	return false;
	        }
	    }// END system_user_type_view_all

	    function system_user_type($sut_id, $sut_type_key=false){
	        $sql = "SELECT * FROM system_users_type WHERE sut_id != ''";

	        if($sut_id){
	        	$sql .= " AND sut_id = '$sut_id' ";
	        }
	        else if($sut_type_key){
	        	$sql .= " AND sut_type_key = '$sut_type_key' ";
	        }
	        else{
	        	return false;
	        }

	        $query=$this->db->query($sql);
	        if($query -> num_rows()>0){
	            // $result = $query->result_array();
	            $result = $query->row_array();
	            return $result;
	        }
	        else{
	        	return false;
	        }
	    }// END system_user_type

		function get_login_info(){			
			$su_email = trim($this -> input -> post('username'));
			$password = trim($this -> input -> post('password'));

	        $sql = "SELECT * FROM system_users, system_users_type WHERE system_users.sut_id = system_users_type.sut_id AND system_users.su_email = '$su_email' AND system_users.su_status='active' ";
	        $query=$this->db->query($sql);
	        if($query->num_rows() == 1){

	            $row = $query->row_array();
	            // echo $password; print_r($row); exit();
	            $su_password = $row['su_password'];

	            if(crypt($password, $su_password)==$su_password){

					$sess_array = array(
							'is_logged_in' => true,
							'su_id' => $row['su_id'],
							'ssut_type_key' => $row['ssut_type_key']
						);
					// Session Array Variable name = ses_digime	
					$this->session->set_userdata('ses_digime', $sess_array);


					$data=array(
						'su_id' => $row['su_id'],
						'suli_login_time' => time(),
						'suli_ip_address' => $this->input->ip_address()
					);
					$this -> db -> insert('system_user_login_info',$data);

	                return TRUE;
	            }
	            else{return FALSE;}
	        }
	        else{
	            return FALSE;
	        }
	    }// END get_login_info

		function logout()
		{
			$session_data = $this->session->userdata('ses_digime');
				
			$this -> db -> select_max('suli_id');
			$this -> db -> from('system_user_login_info');
			$this -> db -> where('su_id',$session_data['su_id']);
			$query=$this -> db -> get();
				foreach($query -> result() as $value):
					$id=$value -> suli_id;
				endforeach;
			
			$data=array(
			'suli_logout_time' => time()
			);
			
			$this->db->where('suli_id', $id);
			$this->db->update('system_user_login_info', $data);

			$this->session->unset_userdata('ses_digime');
			$this->session->sess_destroy();
			return true;
		}// END logout

	}
?>