<div class="box">
	<br>
	<div class="container">
		<div class="row">
			<div class="col-md-10">
				<fieldset>
					<legend>Personal Information</legend>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td>Full Name:</td>
								<td><?=ucfirst($userDetails->first_name) . " " . ucfirst($userDetails->last_name)?></td>
							</tr>
							<tr>
								<td>Phone:</td>
								<td><?=$userDetails->phone?></td>
							</tr>
							<tr>
								<td>Current Address:</td>
								<td><?=$userDetails->current_address?></td>
							</tr>
							<tr>
								<td>Permanent Address:</td>
								<td><?=$userDetails->permanent_address?></td>
							</tr>
							<tr>
								<td>State:</td>
								<td><?=$userDetails->state?></td>
							</tr>
							<tr>
								<td>Country:</td>
								<td><?=$userDetails->country_name?></td>
							</tr>
							<tr>
								<td>Date of Birth:</td>
								<td><?=$userDetails->date_of_birth?></td>
							</tr>
							<tr>
								<td>Postal Code:</td>
								<td><?=$userDetails->postal_code?></td>
							</tr>
						</table>
					</div>
				</fieldset>
			</div>
			<div class="col-md-10">
				<fieldset>
					<legend>Account Information</legend>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td>Username:</td>
								<td><?=$userDetails->username?></td>
							</tr>
							<tr>
								<td>Role:</td>
								<td><?=$userDetails->role_name?></td>
							</tr>
							<tr>
								<td>Department:</td>
								<td><?=$userDetails->department_name?></td>
							</tr>
							<tr>
								<td>Email:</td>
								<td><?=$userDetails->email?></td>
							</tr>
							<tr>
								<td>Status</td>
								<td><?=$userDetails->is_active == 1 ? '<span class="label label-success">Activated</span>' : '<span class="label label-danger">Deactivated</span>'?></td>
							</tr>
							<tr>
								<td>Last Login:</td>
								<td><?=$userDetails->last_login?></td>
							</tr>
							<tr>
								<td>Last IP:</td>
								<td><?=$userDetails->last_ip?></td>
							</tr>
							<tr>
								<td>Last Modified:</td>
								<td><?=$userDetails->modified?></td>
							</tr>
							<tr>
								<td>Date Created:</td>
								<td><i><?=$userDetails->created?></i></td>
							</tr>
						</table>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
</div>