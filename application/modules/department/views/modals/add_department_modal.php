<?=form_open(base_url() . "department/addDepartment", array('id' => 'addDepartmentForm'))?>	
    <div class="modal-header <?=$userInfo->theme_name?>">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Department</h4>
    </div>
    <div class="modal-body">
            <label for="department_name" class="label label-primary">Department name</label>
            <input id="department_name" type="text" name="department_name" class="form-control" required autofocus>
    </div>
    <div class="modal-footer">
            <input id="submitAddDepartment" type="submit" class="btn btn-primary" value="Save">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
<?=form_close()?>

<script>
$("#addDepartmentForm").submit(function(){
	$("body div").css({"-webkit-filter" : "grayscale(15%)",
		"-moz-filter" : "grayscale(15%)",
		"-o-filter" : "grayscale(15%)",
		"-ms-filter" : "grayscale(15%)",
		"filter" : "grayscale(15%)"});

	$("#loadingSVG").show();	
});
</script>