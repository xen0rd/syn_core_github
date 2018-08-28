<?=form_open(base_url() . "support/deletePriority")?>	
	<div class="modal-header <?=$userInfo->theme_name?>">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Delete Priority Level</h4>
	</div>
	<div class="modal-body">
		<p>Are you sure you want to delete this priority level?</p>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="priority_id" value="<?=$this->uri->segment(3)?>">
		<input id="submitDeleteTicket" type="submit" class="btn btn-danger" value="Yes">
		<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	</div>
<?=form_close()?>

<script>
$("#submitDeleteTicket").click(function(){
	$("body div").css({"-webkit-filter" : "grayscale(15%)",
		"-moz-filter" : "grayscale(15%)",
		"-o-filter" : "grayscale(15%)",
		"-ms-filter" : "grayscale(15%)",
		"filter" : "grayscale(15%)"});

	$("#loadingSVG").show();	
});
</script>