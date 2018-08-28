<?=form_open(base_url() . "department/imap", array('id' => 'iMAPSettingsForm'))?>
<?php if(isset($imap->status)){
	$status = $imap->status == 1 ? "checked" : "";
	$SMTPHost = $imap->smtp_host;
	$IMAPHost = $imap->imap_host;
	$IMAPUser = $imap->imap_user;
	$IMAPPass = $imap->imap_pass;
	$IMAPStatus = $imap->status;
}
else{
	$status = 0;
	$SMTPHost = "";
	$IMAPHost = "";
	$IMAPUser = "";
	$IMAPPass = "";
	$IMAPStatus = 0;
}?>
	<div class="modal-header <?=$userInfo->theme_name?>">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Email Configuration</h4>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<small><i>Use custom settings</i></small>
			<input id="toggle_imap_settings_<?=$this->uri->segment(3)?>" class="toggle-imap-settings" <?=$status?> status="<?=$IMAPStatus?>" type="checkbox" data-size="mini"  data-on="On" data-off="Off">
		</div>
		<div class="form-group">
			<label for="imap_user" class="label label-primary">Email</label>
			<input type="text" name="imap_user" id="imap_user" class="form-control imap-setting-field" value="<?=$IMAPStatus == 0 ? '' : $IMAPUser ?? ''?>" required <?=$IMAPStatus == 0 ? "disabled placeholder='Use global settings'" : ""?>>
			<?=form_error('imap_user')?>
		</div>
		<div class="form-group">
			<label for="imap_pass" class="label label-primary">Password</label>
			<input type="password" name="imap_pass" id="imap_pass" class="form-control imap-setting-field" value="<?=$IMAPStatus == 0 ? '' : $IMAPPass ?? ''?>" required <?=$IMAPStatus == 0 ? "disabled placeholder='Use global settings'" : ""?>>
			<?=form_error('imap_pass')?>
		</div>
		<div class="form-group">
			<label for="smtp_host" class="label label-primary">SMTP host (Outgoing)</label>
			<input type="text" name="smtp_host" id="smtp_host" class="form-control imap-setting-field" value="<?=$IMAPStatus == 0 ? '' : $SMTPHost ?? ''?>" required autofocus <?=$IMAPStatus == 0 ? "disabled placeholder='Use global settings'" : ""?>>
			<small class="text-muted"><i>SSL, Port: 465</i></small>
			<?=form_error('smtp_host')?>
		</div>
		<div class="form-group">
			<label for="imap_host" class="label label-primary">IMAP host (Incoming)</label>
			<input type="text" name="imap_host" id="imap_host" class="form-control imap-setting-field" value="<?=$IMAPStatus == 0 ? '' : $IMAPHost ?? ''?>" required autofocus <?=$IMAPStatus == 0 ? "disabled placeholder='Use global settings'" : ""?>>
			<small class="text-muted"><i>SSL, Port: 993</i></small>
			<?=form_error('imap_host')?>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="department_id" value="<?=$this->uri->segment(3)?>">
		<input type="hidden" name="status" value="<?=$IMAPStatus?>">
		<input id="submitIMAPConfiguration" type="submit" class="btn btn-primary" value="Save" disabled>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	</div>
<?=form_close()?>

<script>
$("#iMAPSettingsForm").submit(function(){
	$("body div").css({"-webkit-filter" : "grayscale(15%)",
		"-moz-filter" : "grayscale(15%)",
		"-o-filter" : "grayscale(15%)",
		"-ms-filter" : "grayscale(15%)",
		"filter" : "grayscale(15%)"});

	$("#loadingSVG").show();	
});

$('.toggle-imap-settings').bootstrapToggle({
	width: "30"
});

$('.toggle-imap-settings').change(function(){
	if($(this).is(':checked')){
		$('.imap-setting-field').attr("disabled", false);
		$('.imap-setting-field').attr("placeholder", "");
		$('#smtp_host').val('<?=$imap->smtp_host ?? ''?>');
		$('#imap_host').val('<?=$imap->imap_host ?? ''?>');
		$('#imap_user').val('<?=$imap->imap_user ?? ''?>');
		$('#imap_pass').val('<?=$imap->imap_pass ?? ''?>');
	}
	else{
		$('.imap-setting-field').attr("disabled", "disabled");
		$('.imap-setting-field').attr("placeholder", "Use global settings");
		$('#smtp_host').val('');
		$('#imap_host').val('');
		$('#imap_user').val('');
		$('#imap_pass').val('');
	}
});

$('.imap-setting-field').keypress(function(){
	$('#submitIMAPConfiguration').attr("disabled", false);
});

$('.toggle-imap-settings').change(function(){
	if($(this).prop("checked") == true && $(this).attr("status") == '1'){
		$('input[name=status]').val('1');
		$('#submitIMAPConfiguration').attr("disabled", "disabled");
	}
	if($(this).prop("checked") == false && $(this).attr("status") == '0'){
		$('input[name=status]').val('0');
		$('#submitIMAPConfiguration').attr("disabled", "disabled");
	}
	if($(this).prop("checked") == true && $(this).attr("status") == '0'){
		$('input[name=status]').val('1');
		$('#submitIMAPConfiguration').attr("disabled", false);
	}
	if($(this).prop("checked") == false && $(this).attr("status") == '1'){
		$('input[name=status]').val('0');
		$('#submitIMAPConfiguration').attr("disabled", false);
	}
});
</script>