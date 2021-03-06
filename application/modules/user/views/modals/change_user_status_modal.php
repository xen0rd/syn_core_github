<div class="modal-header <?=$userInfo->theme_name?>">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Change User Status</h4>
</div>
<div class="modal-body">
	<p>Are you sure you want to change this user's status?</p>
</div>
<div class="modal-footer">
	<input type="button" id="confirm_status_change" class="btn btn-primary" data-dismiss="modal" value="Yes">
	<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
<script>
	$("#confirm_status_change").click(function(){
		$.ajax({
			url:"<?=site_url('user/changeUserStatus');?>",
			type: "POST",
			data: {"id" :  <?=$this->uri->segment(3)?>},
			beforeSend: function(){
				$("body div").css({"-webkit-filter" : "grayscale(15%)",
					"-moz-filter" : "grayscale(15%)",
					"-o-filter" : "grayscale(15%)",
	    			"-ms-filter" : "grayscale(15%)",
	    			"filter" : "grayscale(15%)"});
		
				$("#loadingSVG").show();
			},
			success: function(data){
				if(data === "TRUE"){
					$('#toggle_status_' + <?=$this->uri->segment(3); ?>).bootstrapToggle("toggle");
					toastr.success("Status has been successfully changed.");
				}
				else{
					toastr.error("An error occurred, please try again.");
				}

				$("body div").css({"-webkit-filter" : "none",
					"-moz-filter" : "none",
					"-o-filter" : "none",
	    			"-ms-filter" : "none",
	    			"filter" : "none"});
				$("#loadingSVG").hide();
			}
		});
	});
	
</script>