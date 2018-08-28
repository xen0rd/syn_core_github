<div class="container">
	<div class="row">
		<div class="btn-group btn-breadcrumb">
			<a href="<?=base_url()?>submitted_tickets" class="btn btn-default"><i style="font-size:20px;" class="glyphicon glyphicon-home"></i></a>
			<a class="btn btn-default"><i class="fa fa-gears"></i>&nbsp;Settings</a>
			<a href="#" class="btn btn-primary">Account settings</a>
		</div>
	</div>
	<br>
	<?=form_open(current_url(), 'autocomplete="off"')?>
		<div class="row">
			<div class="col-md-6">
				<fieldset>
					<legend>Acount information</legend>
					<div class="form-group">
						<label for="username" class="label label-danger">Username</label>
						<input type="text" id="username" class="form-control" value="<?=$userInfo->username?>" disabled>
					</div>
					<div class="form-group">
						<label for="new_email" class="label label-primary">Email</label>
						<input type="text" name="new_email" id="new_email" class="form-control" value="<?=$userInfo->email?>">
						<?=form_error('new_email');?>
						<?php if($userInfo->new_email != null){?>							
							<div class="input-group">
							    <input type="text" class="form-control" value="<?=$userInfo->new_email?>" disabled>
							    <div class="input-group-addon">
							    	<small><i class="text-muted">Pending&nbsp;</i></small>
							        <a href="remove_pending_email" title="Remove"><span class="glyphicon glyphicon-minus-sign" style="color:red;"></span></a>
							    </div>
							</div>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="security_question_id" class="label label-primary">Security question</label>
						<select name="security_question_id" id="security_question_id" class="form-control">
							<option disabled selected>Please select</option>
							<option value="1" <?=set_select("security_question_id", 1) ?>>What is your first pet's name?</option>
							<option value="2" <?=set_select("security_question_id", 2) ?>>In what city or town does your nearest sibling live?</option>
							<option value="3" <?=set_select("security_question_id", 3) ?>>What was the name of your elementary / primary school?</option>
						</select>
						<?=form_error('security_question_id');?>
					</div>
					<div class="form-group">
						<label for="security_answer" class="label label-primary">Security answer</label>
						<input type="password" name="security_answer" id="security_answer" class="form-control" value="<?=$userInfo->security_answer?>">
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
<script>
	$(function(){
		$("input").keyup(function(){
			$(this).closest('div').find('.alert').fadeOut();
		});

		$("select").change(function(){
			$(this).closest('div').find('.alert').fadeOut();
		});

		$("#security_question_id option").filter(function() {
		    return $(this).text() == "<?=$userInfo->security_question?>"; 
		}).attr('selected', true);
	});
</script>