<div class="form-group">
	<a href="<?=base_url() . 'support/addPriority'?>" class="btn btn-primary" data-toggle="modal" data-target="#add_priority">Add Priority Level &nbsp; <span class="fa fa-plus"></span></a>
</div>
<div class="box">
	<div class="box-body">
		<table id="prioritiesTable" class="table table-hover">
			<thead>
				<tr>
					<th>Priority Level</th>
					<th>Date Created</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Priority Level</th>
					<th>Date Created</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<div class="modal fade" id="change_priority_status">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="delete_priority">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="add_priority">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>


<script>
$(function(){
	loadPriorities();

	$("#delete_priority").on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	});
	
	$("#add_priority").on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	});
	
	$("#change_priority_status").on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	});
	
	function loadPriorities() {
        table = $('#prioritiesTable').DataTable({
            "ajax": '<?php echo site_url('support/getPriorities'); ?>',
            "bDestroy": true,
            "iDisplayLength": 10,
            "columns": [
				{"data": "priority_level"},
				{"data": "date_created"},
				{"data": null, 
					render: function (row) {
						var status = row.status == 1 ? "checked" : "";
						var details = '<a href="<?=base_url()?>support/changePriorityStatus/' + row.id + '"  data-toggle="modal" data-target="#change_priority_status"><input id="toggle_priority_' + row.id + '"class="toggle-status" ' + status + ' type="text" data-size="mini"  data-on="Enabled" data-off="Disabled"></a>';

						$('.toggle-status').bootstrapToggle({
							width: "60"
						});
						
						return details;
					}
                },
                {"data": null, 
					render: function (row) {
						var details = '<a href="<?=base_url()?>support/deletePriority/' + row.id + '" title="Delete priority" data-toggle="modal" data-target="#delete_priority"><span class="fa fa-trash text-danger"></a>';
						return details;
					}
                }
            ],
            "fnInitComplete": function () {
                
            }
        });
    }
});
</script>