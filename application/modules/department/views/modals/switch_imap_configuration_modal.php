<div class="modal-header <?=$userInfo->theme_name?>">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Switch IMAP Settings</h4>
</div>
<div class="modal-body">
	<p>Are you sure you want to change IMAP settings?</p>
	<p>*SMTP can only send email, IMAP is needed to receive emails</p>
</div>
<div class="modal-footer">
	<input type="button" id="confirm_status_change" class="btn btn-primary" data-dismiss="modal" value="Yes">
	<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
</div>
<script>
	$("#confirm_status_change").click(function(){
		$.ajax({
			url:"<?=site_url('department/changeIMAPSettings');?>",
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
					$('#toggle_imap_settings_' + <?=$this->uri->segment(3); ?>).bootstrapToggle("toggle");
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