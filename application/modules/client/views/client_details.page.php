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
								<td><?=ucfirst($clientDetails->first_name) . " " . ucfirst($clientDetails->last_name)?></td>
							</tr>
							<tr>
								<td>Phone:</td>
								<td><?=$clientDetails->phone?></td>
							</tr>
							<tr>
								<td>Current Address:</td>
								<td><?=$clientDetails->current_address?></td>
							</tr>
							<tr>
								<td>Permanent Address:</td>
								<td><?=$clientDetails->permanent_address?></td>
							</tr>
							<tr>
								<td>State:</td>
								<td><?=$clientDetails->state?></td>
							</tr>
							<tr>
								<td>Country:</td>
								<td><?=$clientDetails->country_name?></td>
							</tr>
							<tr>
								<td>Date of Birth:</td>
								<td><?=$clientDetails->date_of_birth?></td>
							</tr>
							<tr>
								<td>Postal Code:</td>
								<td><?=$clientDetails->postal_code?></td>
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
								<td><?=$clientDetails->username?></td>
							</tr>
							<tr>
								<td>Role:</td>
								<td><?=$clientDetails->role_name?></td>
							</tr>
							<tr>
								<td>Department:</td>
								<td><?=$clientDetails->department_name?></td>
							</tr>
							<tr>
								<td>Email:</td>
								<td><?=$clientDetails->email?></td>
							</tr>
							<tr>
								<td>Status</td>
								<td><?=$clientDetails->is_active == 1 ? '<span class="label label-success">Activated</span>' : '<span class="label label-danger">Deactivated</span>'?></td>
							</tr>
							<tr>
								<td>Last Login:</td>
								<td><?=$clientDetails->last_login?></td>
							</tr>
							<tr>
								<td>Last IP:</td>
								<td><?=$clientDetails->last_ip?></td>
							</tr>
							<tr>
								<td>Last Modified:</td>
								<td><?=$clientDetails->modified?></td>
							</tr>
							<tr>
								<td>Date Created:</td>
								<td><i><?=$clientDetails->created?></i></td>
							</tr>
						</table>
					</div>
				</fieldset>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-5">
				<fieldset>
					<legend>History</legend>
					<br><br>
					<div class="form-group text-center">
						<a href="<?=base_url() . "client/submittedTickets/" . $this->uri->segment(3) . "/" . $this->uri->segment(4)?>" class="btn btn-primary btn-lg"><span class="fa fa-ticket fa-lg"></span> &nbsp; Ticket History</a>
						&nbsp;&nbsp;
						<a href="<?=base_url() . "admin/product/order_history/" . $this->uri->segment(3) . "/" . $this->uri->segment(4)?>" class="btn btn-success btn-lg"><span class="fa fa-shopping-cart fa-lg"></span> &nbsp; Order History</a>
					</div>
				</fieldset>
			</div>
			<div class="col-md-5">
				<fieldset>
					<legend>Set Client Password</legend>
					<?=form_open(current_url())?>
						<div class="form-group">
							<label for="password" class="label label-primary">Password</label>
							<input type="password" class="form-control" id="password" name="new_password">
							<?=form_error('new_password');?>
						</div>
						<div class="form-group">
							<label for="confirm_password" class="label label-primary">Confirm Password</label>
							<input type="password" class="form-control" id="confirm_password" name="confirm_new_password">
							<?=form_error('confirm_new_password');?>
						</div>
						<div class="form-group">
							<input type="hidden" name="username" value="<?=$this->uri->segment(4)?>">
							<input type="hidden" name="user_id" value="<?=$this->uri->segment(3)?>">
							<input type="submit" class="btn btn-primary">
						</div>
					<?=form_close()?>
					<br>
				</fieldset>
			</div>
		</div>
	</div>
</div>