<div class="box">
	<div class="box-body">
		<br>
		<div class="form-group float-right" style="float:right;">
			<input id="toggle-closed-tickets" type="checkbox" data-size="mini"  data-on="Show" data-off="Hide">&nbsp; <i><b>closed</b></i> tickets
		</div>
		<br>
		<table id="ticketsTable" class="table table-hover">
			<thead>
				<tr>
					<th>Ticket No.</th>
					<th>Subject</th>
					<th>Priority</th>
					<th>Status</th>
					<th>Date Submitted</th>
					<th>Action</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Ticket No.</th>
					<th>Subject</th>
					<th>Priority</th>
					<th>Status</th>
					<th>Date Submitted</th>
					<th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<div class="modal fade" id="delete_ticket">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="assign_ticket">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<div class="modal fade" id="change_ticket_priority">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>

<script>
$(function(){
	loadActiveTickets();

	$('#toggle-closed-tickets').bootstrapToggle({
		width: "50"
	});

	$('#toggle-closed-tickets').change(function(){
		if($(this).is(':checked')){
			loadTickets();
		}
		else{
			loadActiveTickets();
		}
	});
	
	$("#delete_ticket").on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	});
	
	$("#change_ticket_priority").on('hidden.bs.modal', function () {
	    $(this).data('bs.modal', null);
	});

	$("#assign_ticket").on('hidden.bs.modal', function () {
		$(this).data('bs.modal', null);
	});
	
	function loadTickets() {
        table = $('#ticketsTable').DataTable({
            "ajax": '<?php echo site_url('support/getTickets'); ?>',
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [[ 4, "desc" ]],
            "columns": [
				{"data": "reference_number"},
                {"data": "subject"},
                { 
                    "data": null, 
                    render: function (row) {
                                return row.priority_level === null ? "Pending" : row.priority_level;
                            }
                },
                {"data": "status"},
                {"data": "date_created"},
                {
                    "data": null, 
                    render: function (row) {
                                var actions = '';
                                <?php if($this->session->userdata("u_role") == "admin"){?>
                                	actions = '<a href="<?=base_url()?>support/ticketDetails/' + row.id + '/' + row.reference_number + '/' + row.client_id + '" title="Ticket details"><span class="fa fa-eye"></a> &nbsp;&nbsp;'
	        						+ '<a href="<?=base_url()?>support/assignTicket/' + row.id + '/' + row.reference_number + '/' + row.client_id + '" title="Assign ticket" data-toggle="modal" data-target="#assign_ticket"><span class="fa fa-user"></a> &nbsp;&nbsp;'
	        						+ '<a href="<?=base_url()?>support/changeTicketPriority/' + row.id + '" title="Change ticket priority" data-toggle="modal" data-target="#change_ticket_priority"><span class="fa fa-bar-chart"></a> &nbsp;&nbsp;'
	           						+ '<a href="<?=base_url()?>support/deleteTicket/' + row.id + '/" title="Delete ticket" data-toggle="modal" data-target="#delete_ticket"><span class="text-danger fa fa-trash"></a> ';
           						<?php } else { ?>
           							actions = '<a href="<?=base_url()?>support/ticketDetails/' + row.id + '/' + row.reference_number + '" title="Ticket details"><button class="btn btn-primary"><span class="fa fa-eye">&nbsp;View details</button></a>';
           						<?php }?>				
                                return actions;
                            }
                }
            ],
            "fnInitComplete": function () {
                
            }
        });
    }

	function loadActiveTickets() {
        table = $('#ticketsTable').DataTable({
            "ajax": '<?php echo site_url('support/getActiveTickets'); ?>',
            "bDestroy": true,
            "iDisplayLength": 10,
            "order": [[ 4, "desc" ]],
            "columns": [
				{"data": "reference_number"},
                {"data": "subject"},
                { 
                    "data": null, 
                    render: function (row) {
                                return row.priority_level === null ? "Pending" : row.priority_level;
                            }
                },
                {"data": "status"},
                {"data": "date_created"},
                {
                    "data": null, 
                    render: function (row) {
                                var actions = '';
                                <?php if($this->session->userdata("u_role") == "admin"){?>
                                	actions = '<a href="<?=base_url()?>support/ticketDetails/' + row.id + '/' + row.reference_number + '/' + row.client_id + '" title="Ticket details"><span class="fa fa-eye"></a> &nbsp;&nbsp;'
	        						+ '<a href="<?=base_url()?>support/assignTicket/' + row.id + '/' + row.reference_number + '/' + row.client_id + '" title="Assign ticket" data-toggle="modal" data-target="#assign_ticket"><span class="fa fa-user"></a> &nbsp;&nbsp;'
	        						+ '<a href="<?=base_url()?>support/changeTicketPriority/' + row.id + '" title="Change ticket priority" data-toggle="modal" data-target="#change_ticket_priority"><span class="fa fa-bar-chart"></a> &nbsp;&nbsp;'
	           						+ '<a href="<?=base_url()?>support/deleteTicket/' + row.id + '/" title="Delete ticket" data-toggle="modal" data-target="#delete_ticket"><span class="text-danger fa fa-trash"></a> ';
           						<?php } else { ?>
           							actions = '<a href="<?=base_url()?>support/ticketDetails/' + row.id + '/' + row.reference_number + '" title="Ticket details"><button class="btn btn-primary"><span class="fa fa-eye">&nbsp;View details</button></a>';
           						<?php }?>				
                                return actions;
                            }
                }
            ],
            "fnInitComplete": function () {
                
            }
        });
    }
});
</script>