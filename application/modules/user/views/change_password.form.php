<div class="box">
	<br>
	<div class="container">
		<?=form_open(current_url(), 'autocomplete="off"')?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="old_password" class="label label-primary">Old password</label>
						<input type="password" name="old_password" id="old_password" class="form-control" value="<?=set_value('old_password')?>">
						<?=form_error('old_password');?>
					</div>
					<div class="form-group">
						<label for="new_password" class="label label-primary">Password</label>
						<input type="password" name="new_password" id="new_password" class="form-control" value="<?=set_value('new_password')?>">
						<small class="text-muted">8 - 20 alphanumeric characters</small>
						<?=form_error('new_password');?>
					</div>			
					<div class="form-group">
						<label for="confirm_new_password" class="label label-primary">Confirm password</label>
						<input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" value="<?=set_value('confirm_new_password')?>">
						<?=form_error('confirm_new_password');?>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary">
					</div>
				</div>
			</div>
		<?=form_close();?>
	</div>
</div>