<div class="container">
<h3>Security question</h3>
	<?=form_open('security', 'autocomplete="off"')?>
		<div class="row">
			<div class="col-md-6">
				<fieldset>
					<legend></legend>
					<div class="form-group">
						<label for="security_answer" class="label label-danger"><?=$security_question?></label>
						<input type="password" name="security_answer" id="security_answer" class="form-control" value="<?=set_value('security_answer')?>">
						<input type="hidden" name="username" value="<?=$username?>">
						<?=form_error('security_answer');?>
					</div>
				</fieldset>
			</div>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary">
		</div>
	<?=form_close();?>
</div>