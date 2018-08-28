<div class="container">
	<div class="row">
		<div class="btn-group btn-breadcrumb">
			<a href="<?=base_url()?>" class="btn btn-default"><i style="font-size:20px;" class="glyphicon glyphicon-home"></i></a>
			<a class="btn btn-default">Support</a>
			<a href="#" class="btn btn-primary">Submit a ticket</a>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
			<?=form_open_multipart(current_url())?>
			<div class="form-group">
				<label for="subject" class="label label-primary">Subject</label>
				<input type="text" id="subject" name="subject" class="form-control" value="<?=set_value("subject")?>">
				<?=form_error("subject")?>
			</div>
			<div class="form-group">
				<label for="description" class="label label-primary">Description</label>
				<textarea id="description" name="description" class="form-control"><?=set_value("description")?></textarea>
				<?=form_error("description")?>
			</div>
			<div class="form-group">
				<label for="email" class="label label-primary">Attach Screenshot</label>
				<span class="btn btn-default btn-file">
				    Browse <input type="file" name="attachment" accept=".png, .jpg, .jpeg">
				</span><br>
				<small class="text-muted">Maximum upload size is 1025 kB (.jpeg, .jpg, .png)</small>
				<br>
				<img id="image-preview" width="200"><br><br>
			</div>
			<div class="form-group">
				<input id="submit_ticket" type="submit" class="btn btn-primary">
			</div>
			<?=form_close();?>
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

$("input[name='attachment']").change(function(){
	readFile(this);
});
</script>