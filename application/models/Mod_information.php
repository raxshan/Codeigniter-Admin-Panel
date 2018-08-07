<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Mod_information extends CI_model
	{
		public function __construct()
		{
	        parent::__construct();
		}


	    function do_curl_request($method, $url, $data){

	      	$query = "";
	      	if($method == "GET") {
		 		$query.="?".http_build_query($data);
			}
	        $url = $url.$query;

			// Do Curl
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);

	      	// Disable SSL verification
	      	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			if($method == "GET") {				
					curl_setopt($ch, CURLOPT_POST, false);
	     	} else {
	     	  	if($method == "PUT") {
		          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		          curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: PUT'));
		        }
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));			
			}
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);
			return $output;

			/*
		    print_r($output); exit();

			$return = false;
			$arr = json_decode($output,1);
			if(!$arr) {
			  $arr = $output;
			}

			//return $arr;
		    print_r($arr);
		    */
	    }// END do_curl_request


	    /*
	    Sending SMS Function
	    $type = checkin or checkout;
	    $ci_id = Client ID, who will receive the SMS;
	    */
	    function sending_sms($type, $ci_id){

	    	$data = array();

	    	// SMS Information
	    	$sms_details = $this->sms_details($type);
	    	$sd_id = $sms_details['sd_id'];
	    	$message = $sms_details['sd_body'];

	    	// Client Information
	    	$client_details = $this->client_details($ci_id);
	    	$ci_gid = $client_details['ci_gid'];
			$ci_title = $client_details['ci_title'];
			$ci_first_name = $client_details['ci_first_name'];
			$ci_middle_name = $client_details['ci_middle_name'];
			$ci_last_name = $client_details['ci_last_name'];
			$ci_mobile = $client_details['ci_mobile'];
			$ci_email = $client_details['ci_email'];
			$ci_dob = $client_details['ci_dob'];
			$ci_checkin = $client_details['ci_checkin'];
			$ci_checkout = $client_details['ci_checkout'];
			$ci_room_number = $client_details['ci_room_number'];
			$ci_status = $client_details['ci_status'];

			// Message Modification
			$message = str_replace("<title>",$ci_title,$message);
			$message = str_replace("<fname>",$ci_first_name,$message);
			$message = str_replace("<mname>",$ci_middle_name,$message);
			$message = str_replace("<lname>",$ci_last_name,$message);
			$message = str_replace("<roomno>",$ci_room_number,$message);

			/*
			************************************
			For GP Mobile Number Should BE: 		017XXXXXXXX (11 Length)
			For Robi Mobile Number Should BE: 		88017XXXXXXXX (13 Length)
			For Banglalink Mobile Number Should BE: 88017XXXXXXXX (13 Length)
			************************************
			*/
			// Mobile Number Type Selection
			$substr_ci_mobile = substr($ci_mobile, 0, 3);
			if($substr_ci_mobile == '017'){
				$mobile_number_type = 'banglalink';
				// $mobile_number_type = 'gp';
			}
			else if($substr_ci_mobile == '018'){
				$mobile_number_type = 'robi';
			}
			else if($substr_ci_mobile == '019'){
				$mobile_number_type = 'banglalink';
			}
			else{
				$mobile_number_type = 'banglalink';
			}




	    	// Set DATA
	    	if($mobile_number_type == 'gp'){
				$url = 'https://cmp.grameenphone.com/gpcmpapi/messageplatform/controller.home';
				$data['username'] = 'digitanaz'; // {Valid User Name}
				$data['password'] = 'digN@G@r#201213';
				$data['apicode'] = 1; // {1= for Sending}
				$data['msisdn'] = $ci_mobile; // {Mobile Number Prefix with ZERO}
				$data['countrycode'] = 880; // {For Local Sms}
				$data['cli'] = 'NAZ GARDEN'; // NAZDIRECTOR, NAZ MD, H NAZGARDEN, NAZ GARDEN, SHAFINAHMED
				$data['messagetype'] = 1; // {1 for text ;2 for flash ;3 for unicode(bangla)}
				$data['message'] = $message;
				$data['messageid'] = 0;	    		
	    	}
	    	else if($mobile_number_type == 'robi'){
				$url = 'https://bmpws.robi.com.bd/ApacheGearWS/SendTextMessage';

				$data['Username'] = 'naz_garden';
				$data['Password'] = 'Naz@12345sms';
				$data['From'] = '8801847170111';
				$data['To'] = '88'.$ci_mobile;// Mobile Number with 88
				$data['Message'] = $message;
	    	}
	    	else if($mobile_number_type == 'banglalink'){
				$url = 'https://vas.banglalinkgsm.com/sendSMS/sendSMS';

				$data['msisdn'] = '88'.$ci_mobile;// Mobile Number with 88
				$data['message'] = $message;
				$data['userID'] = 'hotnazgar';
				$data['passwd'] = 'a035a8e959df1f04c872354689a1c4a1';
				$data['sender'] = 'Hotel Naz Garden';
	    	}
	    	else{
	    		return false;
	    	}


	    	// Send SMS do curl
	    	$method = "GET";
	    	$do_curl_request = $this->do_curl_request($method, $url, $data);
	    	// echo '<pre>'; print_r($do_curl_request); exit();


	    	// Insert Into Table tbl_sms_sending_info

	            $data = array (
	                'sd_id' => $sd_id,
					'ci_id' => $ci_id,
					'ssi_sms' => $message,
					'ssi_response_value' => $do_curl_request
	            );
        		$this->db->insert('tbl_sms_sending_info', $data);

	        return true;
	    }// END sending_sms



	    function view_all_clients(){
	        $sql = "SELECT * FROM tbl_client_info WHERE ci_checkin != '' ORDER BY ci_checkin DESC";
	        $query=$this->db->query($sql);
	        //$result = $query->row_array();
        	$result = $query->result_array();
	        return $result;
	    }// END view_all_clients

	    function client_details($ci_id){
	        $sql = "SELECT * FROM tbl_client_info WHERE tbl_client_info.ci_id = '$ci_id'";
	        $query=$this->db->query($sql);
	        if($query -> num_rows()<1){
	            return false;
	        }
	        else{
		        $result = $query->row_array();
	        	//$result = $query->result_array();
		        return $result;	        	
	        }
	    }// END client_details

	    function client_details_by_gid($gid){
	        $sql = "SELECT * FROM tbl_client_info WHERE tbl_client_info.ci_gid = '$gid'";
	        $query=$this->db->query($sql);

	        if($query -> num_rows()<1){
	            return false;
	        }
	        else{
		        $result = $query->row_array();
	        	//$result = $query->result_array();
		        return $result;	        	
	        }
	    }// END client_details

	    function is_valid_mobile($mobile_number){
	    	if($mobile_number!='' && strlen($mobile_number) == 11 && (substr($mobile_number, 0, 2) == '01') ){
	    		return true;
	    	}
	    	else{
	    		return false;
	    	}
	    }// END is_valid_mobile

	    function client_details_update($request_type, $ci_id=NULL){
	        $gid = trim($this->input->post('guest_id'));
			$title = trim($this->input->post('title'));
			$first_name = trim($this->input->post('first_name'));
			$middle_name = trim($this->input->post('middle_name'));
			$last_name = trim($this->input->post('last_name'));
			$dob = trim($this->input->post('dob'));
			$dob = str_replace('/', '-', $dob);
			$dob = strtotime($dob);

			$mobile = trim($this->input->post('mobile'));
	    	$is_valid_mobile = $this->is_valid_mobile($mobile);// return true or false

			$email = trim($this->input->post('email'));

			$checkin_date = trim($this->input->post('checkin_date'));
			$checkin_date = str_replace('/', '-', $checkin_date);
			$checkin_date = strtotime($checkin_date);

			$checkout_date = trim($this->input->post('checkout_date'));
			$checkout_date = str_replace('/', '-', $checkout_date);
			$checkout_date = strtotime($checkout_date);

			$room_number = trim($this->input->post('room_number'));
			$status = trim($this->input->post('status'));

	        if($request_type == 'checkin'){
				// All Field Mendatory
		        if($gid != '' && $title != '' && $first_name != '' && $dob != '' && $is_valid_mobile == true && $email != '' && $checkin_date != '' && $checkout_date != ''){

		            $data = array (
		                'ci_gid' => $gid,
						'ci_title' => $title,
						'ci_first_name' => $first_name,
						'ci_middle_name' => $middle_name,
						'ci_last_name' => $last_name,
						'ci_mobile' => $mobile,
						'ci_email' => $email,
						'ci_dob' => $dob,
						'ci_checkin' => $checkin_date,
						'ci_checkout' => $checkout_date,
						'ci_room_number' => $room_number,
						'ci_status' => $status
		            );
	        		$this->db->insert('tbl_client_info', $data);
	            	$ci_id = $this->db->insert_id();

	        		// Sending SMS
		    		$sending_sms = $this->sending_sms('checkin', $ci_id);

		            return 'added';
		        }
		        else if($is_valid_mobile == false){
		            return 'Invalid Mobile Number'; 
		        }
		        else{
		            // return 'empty-field'; 
		            return 'Invalid Data'; 
		        }
	        }// END if 'checkin'
        	else if($request_type == 'checkout' && $ci_id != NULL){
    			$sending_sms = $this->sending_sms('checkout', $ci_id);
		        return 'Sent Checkout SMS';
        	}// END else if 'checkout'
        	else if($request_type == 'birthday' && $ci_id != NULL){
    			$sending_sms = $this->sending_sms('birthday', $ci_id);
		        return 'Sent Birthday SMS';
        	}// END else if 'birthday'
        	else{
		        return 'Invalid Request';
        	}
	    }// END client_details_update

	    function sms_details($type){
	        $sql = "SELECT * FROM tbl_sms_details, tbl_sms_type WHERE tbl_sms_details.st_id = tbl_sms_type.st_id AND tbl_sms_type.st_key = '$type'";
	        $query=$this->db->query($sql);
	        $result = $query->row_array();
        	//$result = $query->result_array();
	        return $result;
	    }// END sms_details

	    function update_sms_details(){
	        $checkin_message = trim($this->input->post('checkin-message'));
	        $checkout_message = trim($this->input->post('checkout-message'));
	        $birthday_message = trim($this->input->post('birthday-message'));

	        $checkin_sd_id = trim($this->input->post('checkin-id'));
	        $checkout_sd_id = trim($this->input->post('checkout-id'));
	        $birthday_sd_id = trim($this->input->post('birthday-id'));

	        if($checkin_message != '' && $checkout_message != ''){
	            $data = array (
	                'sd_body' => $checkin_message
	            );
	            $this->db->where('sd_id',$checkin_sd_id);
	            $this->db->update('tbl_sms_details',$data);
	            
	            $data = array (
	                'sd_body' => $checkout_message
	            );
	            $this->db->where('sd_id',$checkout_sd_id);
	            $this->db->update('tbl_sms_details',$data);
	            
	            $data = array (
	                'sd_body' => $birthday_message
	            );
	            $this->db->where('sd_id',$birthday_sd_id);
	            $this->db->update('tbl_sms_details',$data);

	            return 'updated';
	        }
	        else{
	            return 'empty-field'; 
	        }
	    }// END update_sms_details

	    function write_user_log($file_name, $message){
        	$message.=' on '.date('F j, Y, h:i:s a', time());

	        $file_location = 'downloads/'.$file_name.'.txt';
	        $file = fopen($file_location,"a");
	        fwrite($file, "\n".$message);
	        fclose($file);
	    }// END write_user_log

	}
?>