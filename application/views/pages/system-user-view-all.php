	
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">View all System User</h1>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<div class="full-body-content">
			        <?php
			            if ($message=='empty-field') {
			              echo '<div class="alert alert-danger"><strong>Error.</strong> Try again. </div>';
			            }
			            if ($message=='updated') {
			              echo '<div class="alert alert-success" role="alert">System User information successfully updated.</div>';
			            }
			            if ($message=='added') {
			              echo '<div class="alert alert-success" role="alert">New System User successfully added.</div>';
			            }
			        ?>
					<table data-toggle="table" data-url="tables/data1.json"  data-search="true" data-pagination="true" data-sort-name="usertype">
					    <thead>
						    <tr>
						        <th data-field="gid" data-sortable="true">Email</th>
						        <th data-field="name"  data-sortable="true">First Name</th>
						        <th data-field="mobile" data-sortable="true">Mobile</th>
						        <th data-field="usertype" data-sortable="true">User Type</th>
						        <th data-field="action" data-sortable="false">Action</th>
						    </tr>
					    </thead>
				    	<?php
				    		if(count($system_users)>0){
				    			echo '<tbody>';
				    			foreach ($system_users as $val) {
				    				echo '<tr>
								        <td>'.$val['su_email'].'</td>
								        <td>'.$val['su_first_name'].'</td>
								        <td>'.$val['su_mobile'].'</td>
								        <td>'.$val['sut_type'].'</td>
								        <td><a href="'.site_url('system-user/add-edit/'.$val['su_id']).'"><i class="fa fa-edit"></i></a></td>
								      </tr>';
				    			}
				    			echo '</tbody>';
				    		}// If row more then 1 | END IF
				    	?>
					    </tbody>
					</table>
				</div>
			</div>
		</div><!--/.row-->