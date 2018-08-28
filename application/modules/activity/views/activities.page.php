<div class="container">
	<div class="row">
		<div class="col-md-11">
			<table id="activity_table" class="table">
				<thead>
					<tr>
						<th>User</th>
						<th>Log</th>
						<th>Module</th>
						<th>Status</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($activities as $activity){?>
						<tr>
							<td><?=ucfirst($activity->first_name)?> <?=ucfirst($activity->last_name)?></td>
							<td><?=$activity->log?></td>
							<td><?=$activity->module_name?></td>
							<td><?=$activity->status == 1 ? "Success" : "Failed" ?></td>
							<td><?=$activity->created?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('#activity_table').DataTable({
	    	"pageLength": 50,
	    	"bLengthChange": false,
	    	"order": [[ 4, "desc" ]]
	    });
	});
</script>