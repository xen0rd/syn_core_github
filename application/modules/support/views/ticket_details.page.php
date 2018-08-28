<?php echo link_tag(css_url()."bubble_chat.css"); ?>
<?php if($this->uri->segment(1) == 'ticket_details'){?>
<div class="container">
<div class="row">
	<div class="btn-group btn-breadcrumb">
		<a href="<?=base_url()?>submitted_tickets" class="btn btn-default"><i style="font-size:20px;" class="glyphicon glyphicon-home"></i></a>
		<a class="btn btn-default">Support</a>
		<a href="<?=base_url() . "submitted_tickets"?>" class="btn btn-default">View submitted ticket(s)</a>
		<a href="#" class="btn btn-primary"># <?=$ticket->reference_number?></a>
	</div>
</div>

<br>
<?php } ?>
<div id="main" role="main">
	<div id="content">
		<div class="row">
			<div class="jarviswidget-color-blueDark"  data-widget-fullscreenbutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false" data-widget-editbutton="false">
				<div class="widget-body no-padding">
					<div class="col-md-12">
						<div class="well table-responsive">
							<div class="row">
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-4 text-muted">
											Ticket Number
										</div>
										<div class="col-md-5">
											<i><?=$ticket->reference_number?></i>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4 text-muted">
											Name
										</div>
										<div class="col-md-5">
											<i><?=ucfirst($ticket->client_first_name) . " " . ucfirst(@$ticket->client_last_name)?></i>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4 text-muted">
											Subject
										</div>
										<div class="col-md-5">
											<i><?=$ticket->subject?></i>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4 text-muted">
											Status
										</div>
										<div class="col-md-5">
											<i><?=$ticket->status?></i>
										</div>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="row">
										<div class="col-md-4 text-muted">
											Department
										</div>
										<div class="col-md-5">
											<i><?=$ticket->department_name ?? "PENDING"?></i>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4 text-muted">
											Assignee
										</div>
										<div class="col-md-5">
											<i><?=ucfirst($ticket->assignee_first_name) . " " . (ucfirst($ticket->assignee_last_name ?? "PENDING"))?></i>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4 text-muted">
											Priority Level
										</div>
										<div class="col-md-5">
											<i><?=$ticket->priority_level ?? "PENDING"?></i>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4 text-muted">
											Date Created
										</div>
										<div class="col-md-5">
											<i><?=$ticket->date_created?></i>
										</div>
									</div>
								</div>
								
								<div class="col-md-4">									
									<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
										<div class="modal-dialog modal-lg" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
												</div>
												<div class="modal-body">
													<img src="" class="enlargeImageModalSource" style="width: 100%;">
												</div>
											</div>
										</div>
									</div>
									<?php if(isset($ticket->attachment)){?>
									<img class="img_attachment" style="max-width: 200px; cursor:zoom-in;" src="<?=uploaded_images_url(). $ticket->attachment;?>">
									<?php } ?>
								</div>
								
							</div>
							<br>
							
							<div class="progress progress-micro no-padding ">
								<div style="width: 100%;" role="progressbar" class="progress-bar progress-bar-primary "></div>
							</div>
							
							<!-- Bubble conversation -->
							<div class="row">
								<div class="col-md-12">            
								<ul class="chat">
									<?php
										foreach($conversation as $reply){?>
										<li class="left clearfix">
											<span class="chat-img pull-left">
												<img src="<?=images_url()?>avatar.jpg" class="img-circle" />
											</span>
											<div class="chat-body clearfix">
												<div class="header">
													<strong class="primary-font"><?=ucfirst($reply->first_name ?? $reply->guest_email) . " " . ucfirst(@$reply->last_name)?></strong>
												</div>
												<p>
													<?=$reply->message?>
												</p>
												<br>
												<small class="pull-right text-muted">
													<span class="glyphicon glyphicon-time"></span><i><?=$reply->date_created?></i>
												</small>
											</div>
										</li>
									<?php }?>
									
									<li class="left clearfix">
										<span class="chat-img pull-left">
											<img src="<?=images_url()?>avatar.jpg" class="img-circle" />
										</span>
										<div class="chat-body clearfix">
											<div class="header">
												<strong class="primary-font"><?=ucfirst($ticket->client_first_name) . " " . ucfirst(@$ticket->client_last_name)?></strong>
											</div>
											<p>
												<?=$ticket->description?>
											</p>
											<br>
											<small class="pull-right text-muted">
												<span class="glyphicon glyphicon-time"></span><i><?=$ticket->date_created?></i>
											</small>
										</div>
									</li>
								</ul>
							</div>
						</div>
										
							<br>
							<div class="progress progress-micro no-padding">
								<div style="width: 100%;" role="progressbar" class="progress-bar progress-bar-primary "></div>
							</div>
							<?php if($this->uri->segment(1) != 'client'){?>
								<?php if($this->uri->segment(1) == "ticket_details"){?>
									<form action="<?=base_url()?>support/reopen" class="smart-form" id="frm_ticket" method="post" style="padding-left:15px; padding-right:15px;">
								<?php } else {?>
									<form action="<?=base_url()?>support/reply" class="smart-form" id="frm_ticket" method="post" style="padding-left:15px; padding-right:15px;">
								<?php }?>
									<table class="table no-border">                                                                                                                                                            
										<div class="row">
											<div class="col col-6">
												<label class="textarea">
													<textarea rows="5" cols="100" placeholder="Type your message here" class="form-control" name="message" id="message"></textarea>
													<b class="tooltip tooltip-top-right"> <i class="fa fa-envelope txt-color-teal"></i> Please enter your comment.</b>
												</label>
												<br>
												<br>
												<input type="hidden" name="ticket_id" value="<?=$ticket->id?>">
												<input type="hidden" name="reference_number" value="<?=$ticket->reference_number?>">
												<input type="hidden" name="client_email" value="<?=$ticket->client_email ?? $ticket->client_first_name?>">
												<input type="hidden" name="assignee_email" value="<?=$ticket->assignee_email?>">
												<input type="hidden" name="client_id" value="<?=$this->uri->segment(5)?>">
												<footer style="background:none; border-top:none;">                                    
													<input id="submit_reply" type="submit" name="submit" value="Submit" class="btn btn-primary" disabled>
												</footer>
											</div>
										</div>     
									</table>                                          
								</form>
							<?php } ?>
						</div>
						<br>
					</div>
					<br>
				</div>
			</div>     
		</div>
	</div>
</div>
<script>
	$(function(){
			$("#message").keyup(function(){
				if($(this).val() == ""){
					$("#submit_reply").attr("disabled", "disabled");
				}
				else{
					$("#submit_reply").attr("disabled", false);
				}
			});
		
	    	$('.img_attachment').on('click', function(){
				$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
				$('#enlargeImageModal').modal('show');
			});
	});
</script>