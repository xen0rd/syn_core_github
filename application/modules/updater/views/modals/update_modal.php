<div class="modal fade" id="update_modal" data-controls-modal="update_modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-center-vertical">
		<div class="modal-content">
			<div class="modal-header <?=$userInfo->theme_name?>">
				<h4 class="modal-title">Downloading update files...</h4>
			</div>
			<div class="modal-body">
				<p>Please wait for a moment. This won&rsquo;t take long.</p>
				<div class="progress progress-md active">
					<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
						<span class="sr-only">0% Complete</span>
					</div>
				</div>
				<p><span style="color:red" class="fa fa-warning" id="updater_message"></span> Do not close/refresh the browser while the update is in progress.</p>
				<small class="text-muted"><i>Updating from version <?=_SYNTHIA_VERSION?> to</i> <i id="label_update_version"></i></small> 
			</div>	
		</div>
	</div>
</div>
<script type="text/javascript">
var progressTimer;

$.ajax({
	url: "<?=base_url()?>/updater/check",
	success: function(data){
		if(data == 0){
			toastr.info("A new version of Synthia is available. It will be installed automatically.");
			download();
		}
	}
});

function download(){
	$.ajax({
		url: "<?=base_url()?>/updater/download",
		beforeSend: function(){
			$("#update_modal").modal("show");
			progressTimer = setInterval(function(){
				getUpdateVersion();
				getProgress();
			}, 100);
		},
		success: function(data){
			backup();
		}
	});
}

function backup(){
	$.ajax({
		url: "<?=base_url()?>/updater/appBackup",
		beforeSend: function(){
			$("#update_modal .modal-title").text("Backing up files...");
		},
		success: function(data){
			if(data == 1){
				$("#update_modal div[role=progressbar]").css("width", "95%");
				setTimeout( function() {
					install();
		       }, 500);
			}
		}
	});
}



function install(){
	$.ajax({
		url: "<?=base_url()?>/updater/install",
		beforeSend: function(){
			$("#update_modal .modal-title").text("Installing update...");
		},
		success: function(data){
			if(data == 1){
				$("#update_modal div[role=progressbar]").css("width", "100%");
				setTimeout( function() {
					$("#update_modal .modal-title").text("Update complete. Restarting...");
					removeInstallationFiles();
		       }, 1000);
			}
			if(data == 0){
				toastr.error("An error occurred while trying to install the update. Please contact support if the problem persists.");
			}
		}
	});
}

function removeInstallationFiles(){
	$.ajax({
		url: "<?=base_url()?>/updater/removeTMP",
		success: function(data){
			setTimeout(function(){
				window.location.reload();
			},5000);
		}
	});
}

function getProgress(){
	$.get('<?=base_url()?>tmp/update_progress', function(data){
		var percentage = parseInt(data);

		$("#update_modal div[role=progressbar]").css("width", percentage + "%");

		if(percentage == 90){
			clearInterval(progressTimer);
		}
	});
}

function getUpdateVersion(){
	$.get('<?=base_url()?>tmp/update_version', function(data){
		$("#update_modal #label_update_version").text(data);
	});
}



</script>