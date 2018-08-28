<div class="container">
<h3>Reset your password</h3>
	<?=form_open(current_url(), 'autocomplete="off"')?>
		<div class="row">
			<div class="col-md-6">
				<fieldset>
					<legend></legend>
					<div class="form-group">
						<label for="username" class="label label-danger">Username</label>
						<input type="text" name="username" id="username" class="form-control" value="<?=set_value('username')?>">
						<?=form_error('username');?>
					</div>
				</fieldset>
			</div>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary">
		</div>
	<?=form_close();?>
</div>