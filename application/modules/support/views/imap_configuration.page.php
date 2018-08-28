<div class="container">
	<?=form_open(current_url(), 'autocomplete="off"')?>
		<div class="row">
		<div class="col-md-11">
			<div class="box box-solid">
				<!-- /.box-header -->
				<div class="box-body">
					<div class="box-group" id="accordion">
						<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
						<?php //foreach($departments as $department) {?>
							<div class="panel box">
								<div class="box-header with-border">
									<h4 class="box-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
											<i class="fa fa-chevron-down"></i> &nbsp; Department Name
										</a>
									</h4>
								</div>
								<div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
									<div class="box-body">
										<div class="form-group">
											<label for="smtp_host" class="label label-primary">IMAP host</label>
											<input type="text" name="smtp_host" id="smtp_host" class="form-control" value="<?php//NULL != set_value('smtp_host') ? set_value('smtp_host') : $smtp->smtp_host?>">
											<?=form_error('smtp_host')?>
										</div>
										<div class="form-group">
											<label for="smtp_user" class="label label-primary">IMAP user</label>
											<input type="text" name="smtp_user" id="smtp_user" class="form-control" value="<?php//NULL != set_value('smtp_user') ? set_value('smtp_user') : $smtp->smtp_user?>">
											<?=form_error('smtp_user')?>
										</div>
										<div class="form-group">
											<label for="smtp_pass" class="label label-primary">IMAP password</label>
											<input type="password" name="smtp_pass" id="smtp_pass" class="form-control" value="<?php//NULL != set_value('smtp_pass') ? set_value('smtp_pass') : $smtp->smtp_pass?>">
											<?=form_error('smtp_pass')?>
										</div>
									</div>
								</div>
							</div>
						<?php //} ?>
					</div>
				</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary">
		</div>
	<?=form_close();?>
</div>
<script>
	$(function(){
		$("input").keyup(function(){
			$(this).closest('div').find('.alert').fadeOut();
		});
	});
</script>