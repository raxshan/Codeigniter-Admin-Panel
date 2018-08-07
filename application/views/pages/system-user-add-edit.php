<?php
	$type = $this->input->post('type');
	$first_name = trim($this->input->post('first_name'));
	$last_name = trim($this->input->post('last_name'));
	$mobile = trim($this->input->post('mobile'));
	$email = trim($this->input->post('email'));
	$status = $this->input->post('status');

	if(!$this->input->post('submit') && $user_details){
		$type = $user_details['sut_id'];
		$first_name = $user_details['su_first_name'];
		$last_name = $user_details['su_last_name'];
		$mobile = $user_details['su_mobile'];
		$email = $user_details['su_email'];
		$status = $user_details['su_status'];
	}
?>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"><?php echo ($user_details) ? 'Update System User Info' : 'Add New System User'; ?></h1>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<div class="full-body-content">
			        <?php
			            if ( isset($message) && $message!='') {
			              echo '<div class="alert alert-danger"><strong>Error.</strong> '.$message.' </div>';
			            }
			        ?>
					<form class="validation" action="" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label>User Type</label>
							<select class="form-control" name="type" required>
								<option value="">Select</option>
							<?php
								foreach ($user_types as $val) {
									$isSelected = ($val['sut_id']==$type) ? 'selected' : '';
									echo '<option value="'.$val['sut_id'].'" '.$isSelected.'>'.$val['sut_type'].'</option>';
								}
							?>
							</select>
						</div>

						<div class="form-group">
							<label>First Name:</label>
							<input type="text" class="form-control" name="first_name" value="<?php echo $first_name; ?>" required>
						</div>

						<div class="form-group">
							<label>Last Name:</label>
							<input type="text" class="form-control" name="last_name" value="<?php echo $last_name; ?>">
						</div>

						<div class="form-group">
							<label>Mobile:</label>
							<input type="text" class="form-control" name="mobile" value="<?php echo $mobile; ?>" placeholder="01XXXXXXXXX"  data-rule-minlength="11" data-rule-maxlength="11" data-msg-minlength="Exactly 11 characters please" data-msg-maxlength="Exactly 11 characters please" required>
						</div>

						<div class="form-group">
							<label>Username / Email:</label>
							<input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
						</div>
				<?php
					if (!$user_details) {
				?>
						<div class="form-group">
							<label>Password:</label>
							<input type="password" class="form-control" id="password" name="password" value="" minlength="5" required>
						</div>
						<div class="form-group">
							<label>Re-type Password:</label>
							<input type="password" class="form-control" name="retype_password" value="" data-rule-equalTo="#password" required>
						</div>
				<?php
					}// END IF not user_details
				?>

						<div class="form-group">
							<label>Status</label>
							<select class="form-control select-category" name="status" required>
								<option value="1" <?php echo ($status) ? 'selected' : ''; ?> >Active</option>
								<option value="0" <?php echo ($status) ? '' : 'selected'; ?> >Inactive</option>
							</select>
						</div>

						<div class="next-step">
							<button type="submit" class="btn btn-primary" name="submit" value="1">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div><!--/.row-->
