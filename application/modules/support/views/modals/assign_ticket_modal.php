<?=form_open(base_url() . "support/assign_ticket")?>
	<div class="modal-header <?=$userInfo->theme_name?>">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Assign Ticket</h4>
	</div>
	<div class="modal-body">
		<div class="form-group">	
			<select id="select_department" class="form-control">
				<option selected disabled>Select department</option>
				<?php foreach($departments as $department){?>
					<option value="<?=$department->id?>"><?=$department->department_name?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<select id="select_assignee" name="assignee_id" class="form-control" disabled>
				<option selected disabled>Select assignee</option>
			</select>
		</div>
	</div>
	<div class="modal-footer">
		<input name="ticket_id" type="hidden" value="<?=$this->uri->segment(3)?>">
		<input name="reference_number" type="hidden" value="<?=$this->uri->segment(4)?>">
		<input id="submitAssignTicket" type="submit" class="btn btn-danger" value="Ok" disabled>
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	</div>
<?=form_close()?>

<script>
$("#submitAssignTicket").click(function(){
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
		
		$("#select_department").change(function(){
			var departmentId = $(this).val();
			$.ajax({
				url: "<?=site_url('department/getDepartmentMembers');?>",
				type: "POST",
				data: {"department_id" : departmentId},
				success: function(data){
					$("#select_assignee").attr("disabled", false);
					var obj = $.parseJSON(data);
					var options = "<option selected disabled>Select assignee</option>";
					$.each(obj, function(key, value){
						var first_name = value.first_name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
						    return letter.toUpperCase()
					    });
					    
						var last_name = value.last_name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
						    return letter.toUpperCase()
					    });
					    
						options += "<option value='" + value.id + "'>" + first_name + " " + last_name + "(" + value.username + ")</option>";
						$("#select_assignee").empty().append(options);
					});
				}
				,error: function(a,b,c){
					console.log(a);
					console.log(b);
					console.log(c);
				}
			});
		});

		$("#select_assignee").change(function(){
			$("#submitAssignTicket").attr("disabled", false);
		});

		if("<?=$ticket->assignee_id?>" != ""){
			$("#select_department").val("<?=$ticket->department_id?>").trigger("change");
			setTimeout(function(){
				$("#select_assignee").val("<?=$ticket->assignee_id?>");
			},500);
		}
		
	});
</script>