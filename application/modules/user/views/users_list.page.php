<div class="box">
	<div class="box-body">
		<table id="ticketsTable" class="table table-hover">
			<thead>
				<tr>
					<th>Username</th>
					<th>Full name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Username</th>
					<th>Full name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<div class="modal fade" id="change_user_status">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<script>
$(function(){

	$("#change_user_status").on('hidden.bs.modal', function () {
		$(this).data('bs.modal', null);
	});
	
	
        table = $('#ticketsTable').DataTable({
            "ajax": '<?php echo site_url('user/getUsers'); ?>',
            "bDestroy": true,
            "iDisplayLength": 10,
            "columns": [
				{"data": "username"},
                { 
                    "data": null, 
                    render: function (row) {
		                    	var firstName = row.first_name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
								    return letter.toUpperCase()
							    });
							    
		                    	var lastName = row.last_name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
								    return letter.toUpperCase()
							    });
							    
                                return firstName + " " + lastName;
                            }
                },
                {"data": "email"},
                { 
                    "data": null, 
                    render: function (row) {
                        		var label = '';
                        		var roleName = row.role_name.toLowerCase().replace(/\b[a-z]/g, function(letter) {
								    return letter.toUpperCase()
							    });
							    
                        		if(row.role_name == "admin"){
									label = 'danger';
                            	}
                        		else{
									label = 'success';
                                }

                        		return '<span class="label label-' + label + '">' + roleName + '</span>';
                            }
                },
                {"data": null, 
					render: function (row) {
						var status = row.is_active == 1 ? "checked" : "";
						var details = '<a href="<?=base_url()?>user/changeUserStatus/' + row.id + '"  data-toggle="modal" data-target="#change_user_status"><input id="toggle_status_' + row.id + '"class="toggle-status" ' + status + ' type="text" data-size="mini"  data-on="Active" data-off="Inactive"></a>';

						$('.toggle-status').bootstrapToggle({
							width: "60"
						});
						
						return details;
					}
                },
                {
                    "data": null, 
                    render: function (row) {
                                return '<a href="<?=base_url()?>user/userDetails/' + row.id + '/' + row.username + '" title="View profile"><span class="fa fa-eye"></span></a>';
                            }
                }
            ],
            "fnInitComplete": function () {
                
            }
        });
    
});
</script>