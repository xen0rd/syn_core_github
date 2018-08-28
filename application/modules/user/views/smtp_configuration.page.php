<div class="box">
	<br>
	<div class="container">
		<div class="row">
			<div class="col-md-5">
				<?=form_open(current_url(), 'autocomplete="off"')?>
					<div class="form-group">
						<label for="smtp_user" class="label label-danger">Email</label>
						<input type="text" name="smtp_user" id="smtp_user" class="form-control" value="<?=NULL != set_value('smtp_user') ? set_value('smtp_user') : $smtp->smtp_user?>">
						<?=form_error('smtp_user')?>
					</div>
					<div class="form-group">
						<label for="smtp_pass" class="label label-danger">Password</label>
						<input type="password" name="smtp_pass" id="smtp_pass" class="form-control" value="<?=NULL != set_value('smtp_pass') ? set_value('smtp_pass') : $smtp->smtp_pass?>">
						<?=form_error('smtp_pass')?>
					</div>
					<div class="form-group">
						<label for="smtp_host" class="label label-danger">SMTP host (Outgoing)</label>
						<input type="text" name="smtp_host" id="smtp_host" class="form-control" value="<?=NULL != set_value('smtp_host') ? set_value('smtp_host') : $smtp->smtp_host?>">
						<small class="text-muted"><i>SSL, Port: 465</i></small>
						<?=form_error('smtp_host')?>
					</div>
					<div class="form-group">
						<label for="imap_host" class="label label-danger">IMAP host (Incoming)</label>
						<input type="text" name="imap_host" id="imap_host" class="form-control" value="<?=NULL != set_value('imap_host') ? set_value('imap_host') : $smtp->imap_host?>">
						<small class="text-muted"><i>SSL, Port: 993</i></small>
						<?=form_error('imap_host')?>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary">
					</div>
				<?=form_close();?>
			</div>
		
		</div>	
	</div>
</div>
<script>
	$(function(){
		$("input").keyup(function(){
			$(this).closest('div').find('.alert').fadeOut();
		});
	});
</script>