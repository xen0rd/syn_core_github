<?=form_open(base_url() . "support/changeTicketPriority")?>	
	<div class="modal-header <?=$userInfo->theme_name?>">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Change Priority Level</h4>
	</div>
	<div class="modal-body">
		<select name="priority_level" class="form-control">
			<option selected disabled>Please select</option>
			<?php foreach($priority_levels as $priority){?>
				<option value="<?=$priority->id?>"> <?=$priority->priority_level?></option>
			<?php } ?>
		</select>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="ticket_id" value="<?=$this->uri->segment(3)?>">
		<input id="submitChangePriority" type="submit" class="btn btn-primary" value="Save">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	</div>
<?=form_close()?>

<script>
$("#submitChangePriority").click(function(){
	$("body div").css({"-webkit-filter" : "grayscale(15%)",
		"-moz-filter" : "grayscale(15%)",
		"-o-filter" : "grayscale(15%)",
		"-ms-filter" : "grayscale(15%)",
		"filter" : "grayscale(15%)"});

	$("#loadingSVG").show();	
});
</script>

<script>
	$(function(){
		console.log("<?=$ticket_details->priority_id?>");
		if("<?=$ticket_details->priority_id?>" != ""){
			$("select[name=priority_level]").val("<?=$ticket_details->priority_id?>");
		}
	});
</script>