<div class="form-group">
	<a href="<?=base_url() . 'department/addDepartment'?>" class="btn btn-primary" data-toggle="modal" data-target="#add_department">Add Department &nbsp; <span class="fa fa-plus"></span></a>
</div>
<div class="box">
	<div class="box-body">
		<table id="departmentsTable" class="table table-hover">
			<thead>
				<tr>
					<th>Department Name</th>
					<th>Date Created</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Department Name</th>
					<th>Date Created</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<div class="modal fade" id="add_department">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="change_department_status">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="delete_department">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="imap_settings">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>


<script>
$(function(){
	loadDepartments();

	$("#delete_ticket").on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	});

	$("#change_department_status").on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	});
	
	$("#imap_settings").on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	});
	
	function loadDepartments() {
        table = $('#departmentsTable').DataTable({
            "ajax": '<?php echo site_url('department/getdepartments'); ?>',
            "bDestroy": true,
            "iDisplayLength": 10,
            "columns": [
				{"data": "department_name"},
				{"data": "date_created"},
				{"data": null, 
					render: function (row) {
						var status = row.status == 1 ? "checked" : "";
						var details = '<a href="<?=base_url()?>department/changeStatus/' + row.id + '"  data-toggle="modal" data-target="#change_department_status"><input id="toggle_department_' + row.id + '"class="toggle-status" ' + status + ' type="text" data-size="mini"  data-on="Enabled" data-off="Disabled"></a>';

						$('.toggle-status').bootstrapToggle({
							width: "60"
						});
						
						return details;
					}
                },
                {"data": null, 
					render: function (row) {
						var details = '<a href="<?=base_url()?>department/imap/' + row.id + '" title="Email Settings" data-toggle="modal" data-target="#imap_settings"><span class="fa fa-cog"></a> &nbsp;' +
										'<a href="<?=base_url()?>department/deleteDepartment/' + row.id + '" title="Delete department" data-toggle="modal" data-target="#delete_department"><span class="fa fa-trash text-danger"></a>';
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