<div class="box">
	<br>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<fieldset>
					<legend>Logo</legend>
					<?=form_open_multipart(current_url() . "/reg")?>
					<div class="form-group">
						<label for="email" class="label label-primary">Upload Logo*</label>
						<span class="btn btn-default btn-file">
						    Browse <input type="file" name="logo">
						</span><br>
						<input type="hidden" name="field">
						<small class="text-muted">*Logo will be automatically resized to 130x45 pixels for optimum display</small>
						<br>
						<small class="text-muted">*Maximum upload size is 1025 kB (.gif, .jpg, .png)</small>
						<br>
						<img id="image-preview" width="200"><br><br>
					</div>
					<div class="form-group">
						<input id="submitReg" type="submit" class="btn btn-primary" disabled>
					</div>
					<?=form_close();?>
				</fieldset>
			</div>
			<div class="col-md-6">
				<fieldset>
					<legend>Mini logo</legend>
					<?=form_open_multipart(current_url() . "/mini")?>
					<div class="form-group">
						<label for="email" class="label label-primary">Upload Mini Logo*</label>
						<span class="btn btn-default btn-file">
						    Browse <input type="file" name="mini_logo">
						</span><br>
						<input type="hidden" name="mini-field">
						<small class="text-muted">*Mini logo will be used for shrank sidebar</small>
						<br>
						<small class="text-muted">*Mini logo will be automatically resized to 50x50 pixels for optimum display</small>
						<br>
						<small class="text-muted">*Maximum upload size is 1025 kB (.gif, .jpg, .png)</small>
						<br>
						<img id="mini-image-preview" width="200"><br><br>
					</div>
					<div class="form-group">
						<input id="submitMini" type="submit" class="btn btn-primary" disabled>
					</div>
					<?=form_close();?>
				</fieldset>
			</div>
		</div>
	</div>
</div>
<script>
function readFile(input){
	if(input.files && input.files[0]){
		var reader = new FileReader();

		reader.onload = function(e){
			$('#image-preview').attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	}
}

$("input[name='logo']").change(function(){
	$("#submitReg").attr("disabled", false);
	readFile(this);
});


function readMiniFile(input){
	if(input.files && input.files[0]){
		var reader = new FileReader();

		reader.onload = function(e){
			$('#mini-image-preview').attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	}
}

$("input[name='mini_logo']").change(function(){
	$("#submitMini").attr("disabled", false);
	readMiniFile(this);
});



</script>