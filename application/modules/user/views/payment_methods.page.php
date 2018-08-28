<div class="box">
	<br>
	<div class="container">
            <?=form_open(current_url(), 'autocomplete="off"')?>
		<div class="row">
			<div class="col-md-5">
                                <div class="form-group">
                                        <label for="business_email" class="label label-danger">Business Email</label>
                                        <input type="text" name="business_email" id="business_email" class="form-control" value="<?=NULL != set_value('business_email') ? set_value('business_email') : $payment_method->business_email?>">
                                        <?=form_error('business_email')?>
                                </div>
			</div>
		</div>	
		<div class="row">
			<div class="col-md-5">
                                <div class="form-group">
                                        <label for="identity_token" class="label label-danger">Identity Token</label>
                                        <input type="text" name="identity_token" id="business_email" class="form-control" value="<?=NULL != set_value('identity_token') ? set_value('identity_token') : $payment_method->identity_token?>">
                                        <?=form_error('identity_token')?>
                                </div>
			</div>
		</div>	
		<div class="row">
			<div class="col-md-5">
                                <div class="form-group">
                                        <input type="submit" class="btn btn-primary">
                                </div>
			</div>
		</div>	
            <?=form_close();?>
	</div>
</div>
<script>
	$(function(){
		$("input").keyup(function(){
			$(this).closest('div').find('.alert').fadeOut();
		});
	});
</script>