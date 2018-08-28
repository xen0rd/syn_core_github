<div class="container">
	<?=form_open(current_url(), 'autocomplete="off"')?>
		<div class="row">
			<div class="col-md-6">
				<fieldset>
					<legend>Enter new password</legend>
					<div class="form-group">
						<label for="new_password" class="label label-primary">New password</label>
						<input type="password" name="new_password" id="new_password" class="form-control" value="<?=set_value('new_password')?>">
						<?=form_error('new_password');?>
					</div>
					<div class="form-group">
						<label for="confirm_new_password" class="label label-primary">Confirm new password</label>
						<input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" value="<?=set_value('confirm_new_password')?>">
						<?=form_error('confirm_new_password');?>
					</div>
				</fieldset>
			</div>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary">
		</div>
	<?=form_close();?>
</div>