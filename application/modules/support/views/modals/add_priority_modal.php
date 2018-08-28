<?=form_open(base_url() . "support/addPriority")?>	
	<div class="modal-header <?=$userInfo->theme_name?>">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Add Priority Level</h4>
	</div>
	<div class="modal-body">
		<label for="priority_level" class="label label-primary">Level name</label>
		<input id="priority_level" type="text" name="priority_level" class="form-control" autofocus>
	</div>
	<div class="modal-footer">
		<input id="submitAddPriority" type="submit" class="btn btn-primary" value="Save">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	</div>
<?=form_close()?>

<script>
$("#submitAddPriority").click(function(){
	$("body div").css({"-webkit-filter" : "grayscale(15%)",
		"-moz-filter" : "grayscale(15%)",
		"-o-filter" : "grayscale(15%)",
		"-ms-filter" : "grayscale(15%)",
		"filter" : "grayscale(15%)"});

	$("#loadingSVG").show();	
});
</script>