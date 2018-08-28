<div class="container">
	<?php if($this->uri->segment(1) != 'client'){?>
	<div class="row">
		<div class="btn-group btn-breadcrumb">
			<a href="<?=base_url()?>" class="btn btn-default"><i style="font-size:20px;" class="glyphicon glyphicon-home"></i></a>
			<a class="btn btn-default">Support</a>
			<a href="#" class="btn btn-primary">View submitted ticket(s)</a>
		</div>
	</div>
	<br>
	<?php } ?>
        <div class="box">
            <div class="box-body">
                <table id="ticketsTable" class="table table-hover">
                        <thead>
                                <tr>
                                        <th style="display:none;"></th>
                                        <th>Ticket No.</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Date Submitted</th>
                                </tr>
                        </thead>
                        <tbody>
                                <?php foreach($submittedTickets as $ticket){?>
                                        <tr class="ticketRow" style="cursor:pointer;">
                                                <td style="display:none;"><?=$ticket->id?></td>
                                                <td><?=$ticket->reference_number?></td>
                                                <td><?=$ticket->subject?></td>
                                                <td><?=$ticket->status?></td>
                                                <td><?=$ticket->date_created?></td>
                                        </tr>
                                <?php } ?>
                        </tbody>
                </table>
            </div>
        </div>
</div>
<script>
$(function(){
	$(".ticketRow").click(function(){
		var ticketId = $(this).children("td:first").text();
		var referenceNumber = $(this).children("td:nth(1)").text();
		<?php if($this->uri->segment(1) == 'client'){?>
			window.location.href = "<?=base_url()?>client/ticketDetails/<?=$this->uri->segment(3)?>/<?=$this->uri->segment(4)?>/" + ticketId + "/" + referenceNumber;
		<?php }else{?>
			window.location.href = "<?=base_url()?>ticket_details/" + ticketId + "/" + referenceNumber;
		<?php }?>
	});
});
</script>