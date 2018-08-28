<?php
/**
 *
 * @author Dean Manalo
 * @version Support 1.0.1
 *
 */
class Support extends MX_Controller{
	private $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('imap');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		$this->load->module('client');
		$this->load->module('department');
		$this->load->module('user');
		$this->load->model('support_model');
		
		if(!is_dir("uploads")){
			$mask = umask(0);
			mkdir("uploads", 0775);
			umask($mask);
		}
	}
	
	public function index(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$this->data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$this->data['sidebar'] = $this->load->view("sidebar/sidebar.php", $this->data, TRUE);
			$this->data['active']['menu'] = "Support";
			$page = null;
			
			if($this->uri->segment(2) === "tickets"){
				$page = "tickets.page";
				$this->data['active']['sub_menu'] = "Tickets";
			}
			else if($this->uri->segment(2) === "priorities"){
				if($this->session->userdata("u_role") != "admin"){
					echo "403 Forbidden";
				}
				else{
					$page = "ticket_priorities.page";
					$this->data['active']['sub_menu'] = "Ticket Priority Levels";
				}
			}
			/* else if($this->uri->segment(2) === "imap"){
				$page = "imap_configuration.page";
				$this->data['active']['sub_menu'] = "IMAP Configuration";
			} */
			
			
			render($page, "user.template", $this->data);
			$this->user->loadUpdaterModal();
		}
	}
	
	public function getTickets(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			if($this->session->userdata("u_role") == "admin"){
				$tickets = $this->support_model->tickets();
				$ticketPriorities = $this->support_model->activePriorities();
				echo json_encode(array("data" => $tickets));
			}
			else if($this->session->userdata("u_role") == "staff"){
				echo json_encode(array("data" => $this->support_model->assignedTickets($this->session->userdata("u_id"))));
			}
		}
	}
	
	public function getActiveTickets(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			if($this->session->userdata("u_role") == "admin"){
				$tickets = $this->support_model->activeTickets();
				$ticketPriorities = $this->support_model->activePriorities();
				echo json_encode(array("data" => $tickets));
			}
			else if($this->session->userdata("u_role") == "staff"){
				echo json_encode(array("data" => $this->support_model->assignedActiveTickets($this->session->userdata("u_id"))));
			}
		}
	}
	
	public function changeTicketPriority(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			if($this->input->post(NULL, TRUE)){
				$ticketId = $this->input->post("ticket_id", TRUE);
				$referenceNumber = $this->support_model->referenceNumber($ticketId);
				$priorityLevel = $this->input->post("priority_level", TRUE);
				$priorityName = $this->support_model->priorityName($priorityLevel);
				if($this->support_model->updateTicketPriorityLevel($ticketId, $priorityLevel)){
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Ticket #<b>' . $referenceNumber . '</b>&apos;s priority has been <i>set</i> to <b>' . $priorityName . '</b>', 1, _SUPPORT);
					$this->session->set_flashdata("success_message", "Ticket priority level has been updated");
					redirect("support/tickets");
				}
				else{
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> ticket #<b>' . $referenceNumber . '</b>&apos;s priority level', 0, _SUPPORT);
					$this->session->set_flashdata("error_message", "Failed to update ticket priority level.");
					redirect("support/tickets");
				}
			}
			else{
				$this->data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
				$this->data['priority_levels'] = $this->support_model->activePriorities();
				// if($this->uri->segment(5) === "null"){
					$this->data['ticket_details'] = $this->support_model->guestTicketDetails($this->uri->segment(3));
				/* }
				else{
					$this->data['ticket_details'] = $this->support_model->ticketDetails($this->uri->segment(3));
				} */
				$this->load->view("modals/change_ticket_priority_modal", $this->data);
			}
		}
	}
	
	public function getPriorities(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			echo json_encode(array("data" => $this->support_model->priorities()));
		}
	}
	
	public function reOpenTicket(){
		$this->replyToAssignee();
	}
	
	public function closeTicket(){
		$this->replyToClient();
	}
	
	public function getSubmittedTickets(){
		if($this->auth->isClientLoggedIn()){
			$clientId = $this->session->userdata("c_id");
			$data['submittedTickets'] = $this->support_model->submittedTickets($clientId);
			render("submitted_tickets.page", "client.template", $data);
		}
		else{
			echo "ERROR 403 FORBIDDEN";
		}
	}
	
	public function submittedTicketsDetails(){
		if(!$this->auth->isClientLoggedIn()){
			redirect("/");
		}
		else{
			$ticketId = $this->uri->segment(2);
			$reference_number = $this->uri->segment(3);
			$this->data['ticket'] = $this->support_model->ticketDetails($ticketId);
			$this->data['conversation'] = $this->support_model->ticketReplies($reference_number);
				
			render("support/ticket_details.page", "client.template", $this->data);
		}
	}
	
	public function replyToClient(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$this->data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$this->data['sidebar'] = $this->load->view("sidebar/sidebar.php", $this->data, TRUE);
			$userId = $this->session->userdata("u_id");
			$ticketId = $this->input->post("ticket_id", TRUE);
			$referenceNumber = $this->input->post("reference_number", TRUE);
			$clientEmail = $this->input->post("client_email", TRUE);
			$message = $this->input->post("message", TRUE);
			$clientId = $this->input->post("client_id", TRUE);
			$departmentId = $this->auth_model->userInfo($this->session->userdata("u_username"))->department_id;
			if($this->support_model->addReply($userId, $referenceNumber, $message)){
				$this->support_model->updateTicketStatus($ticketId, "Closed");
				$this->sendToClient($clientEmail, $referenceNumber, $message, $departmentId);
				$this->autoAssignTicket($userId, $ticketId);
				$this->synthia->audit_trail((int)$userId, '<i>Replied</i> to ticket #<b>' . $referenceNumber . '</b>', 1, _SUPPORT);
				$this->session->set_flashdata("success_message", "Reply sent!");
				if($clientId === "null"){
					redirect("support/ticketDetails/" . $ticketId . "/" . $referenceNumber . "/null");
				}
				else{
					redirect("support/ticketDetails/" . $ticketId . "/" . $referenceNumber);
				}
			}
			else{
				$this->synthia->audit_trail((int)$userId,'<i>Reply</i> to ticket #<b>' . $referenceNumber . '</b> has failed', 0, _SUPPORT);
				if($clientId === "null"){
					redirect("support/ticketDetails/" . $ticketId . "/" . $referenceNumber . "/null");
				}
				else{
					redirect("support/ticketDetails/" . $ticketId . "/" . $referenceNumber);
				}
			}
		}
	}
	
	public function replyToAssignee(){
		if(!$this->auth->isClientLoggedIn()){
			redirect("/");
		}
		else{
			$userId = $this->session->userdata('c_id');
			$ticketId = $this->input->post("ticket_id", TRUE);
			$referenceNumber = $this->input->post("reference_number", TRUE);
			$assigneeEmail = $this->input->post("assignee_email", TRUE);
			$message = $this->input->post("message", TRUE);
			if($this->support_model->addReply($userId, $referenceNumber, $message)){
				$this->support_model->updateTicketStatus($ticketId, "Open");
				$this->sendToAssignee($assigneeEmail, $referenceNumber, $message);
				$this->synthia->audit_trail((int)$userId, 'Client has <i>replied</i> to ticket #<b>' . $referenceNumber . '</b>', 1, _SUPPORT);
				$this->session->set_flashdata("success_message", "Reply sent!");
				redirect("ticket_details/" . $ticketId . "/" . $referenceNumber);
			}
			else{
				$this->synthia->audit_trail((int)$userId,'Client <i>reply</i> to ticket #<b>' . $referenceNumber . '</b> has failed', 0, _SUPPORT);
				redirect("ticket_details/" . $ticketId . "/" . $referenceNumber);
			}
		}
	}
	
	public function deleteTicket(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$this->data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$this->data['sidebar'] = $this->load->view("sidebar/sidebar.php", $this->data, TRUE);
			if($this->input->post(NULL, TRUE)){
				$ticketNumber = $this->input->post('ticket_number', TRUE);
				$referenceNumber = $this->support_model->referenceNumber($ticketNumber);
				if($this->support_model->deleteTicket($ticketNumber)){
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Ticket #<b>' . $referenceNumber . '</b> has been <i>deleted</i>', 1, _SUPPORT);
					$this->session->set_flashdata("success_message", "Ticket has been successfully deleted.");
					redirect("support/tickets");
				}
				else{
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>delete</i> ticket #<b>' . $referenceNumber . '</b>', 0, _SUPPORT);
					$this->session->set_flashdata("error_message", "Failed to delete ticket.");
					redirect("support/tickets");
				}
			}
			else{
				$this->load->view("modals/delete_ticket_modal", $this->data);
			}
		}
	}
	
	protected function autoAssignTicket($assigneeId, $ticketId){
		$this->support_model->updateAssignedTicket($assigneeId, $ticketId);
	}
	
	public function assignTicket(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$this->load->module('department');
			$this->data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$this->data['departments'] = $this->department_model->activeDepartments();
			$this->data['sidebar'] = $this->load->view("sidebar/sidebar.php", $this->data, TRUE);
				
			if($this->input->post(NULL, TRUE)){
				$assigneeId = $this->input->post("assignee_id", TRUE);
				$assigneeName = $this->support_model->assigneeName($assigneeId);
				$ticketId = $this->input->post("ticket_id", TRUE);
				$referenceNumber = $this->input->post("reference_number", TRUE);
				$assigneeEmail = $this->support_model->assigneeEmail($assigneeId);
				if($this->support_model->updateAssignedTicket($assigneeId, $ticketId)){
					$this->assignToStaff($assigneeEmail, $referenceNumber);
					$this->support_model->updateTicketStatus($ticketId, "Open");
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Ticket #<b>' . $referenceNumber . '</b> has been assigned to ' . $assigneeName, 1, _SUPPORT);
					$this->session->set_flashdata("success_message", "Ticket has been successfully assigned");
					redirect('/support/tickets');
				}
				else{
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to assign ticket #<b>' . $referenceNumber . '</b> to ' . $assigneeName, 0, _SUPPORT);
					$this->session->set_flashdata("error_message", "Failed to assign ticket.");
					redirect('/support/tickets');
				}
			}
			else{
				$ticketId = $this->uri->segment(3);
				if($this->uri->segment(5) === "null"){
					$this->data['ticket'] = $this->support_model->guestTicketDetails($ticketId);
				}
				else{
					$this->data['ticket'] = $this->support_model->ticketDetails($ticketId);
				}
				$this->load->view("modals/assign_ticket_modal", $this->data);
			}
		}
	}
	
	
	public function createTicket(){
		if($this->auth->isClientLoggedIn()){
			if($this->input->post(NULL, TRUE)){
	 			if($this->form_validation->run('create_ticket')){
	 				$clientId = $this->support_model->clientId($this->session->userdata('c_username'));
	 				$_POST['client_id'] = $clientId;
	 				if(empty($_FILES['attachment']['name'])){
	 					$ticketId = $this->support_model->addTicket($this->input->post(NULL, TRUE));
	 					if($ticketId === FALSE){
	 						$this->synthia->audit_trail((int)$clientId, 'Ticket <i>creation</i> failed', 0, _SUPPORT);
	 						$this->session->set_flashdata("error_message", "Ticket creation failed. Please try again.");
	 						render("support/create_ticket.form", "client.template");
	 					}
	 					else{
	 						$referenceNumber = $this->support_model->referenceNumber($ticketId);
	 						$this->newTicketNotification($referenceNumber);
	 						$this->synthia->audit_trail((int)$clientId, 'Ticket #<b>' . $referenceNumber . '</b> has been <i>created</i>', 1, _SUPPORT);
	 						$this->session->set_flashdata("success_message", "Ticket has been submitted successfully.");
	 						redirect(base_url() . "submitted_tickets");
	 					}
	 				}
	 				else {
	 					
	 					$fileName = date('mdY') . time();
	 					$config['file_name'] = $fileName;
	 					$config['upload_path'] = './uploads/';
	 					$config['allowed_types'] = 'gif|jpg|png';
	 					$config['max_size'] = 1024;
	 					$config['max_width'] = 0;
	 					$config['max_height'] = 0;
	 					$fileExtension = pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION);
	 					$_POST['attachment'] = $fileName . "." . $fileExtension;
	 					
	 					$this->load->library('upload', $config);
	 					
	 					if(!$this->upload->do_upload('attachment')){
	 						$error = array('error' => $this->upload->display_errors());
	 						log_message('error', $error);
	 						$this->synthia->audit_trail((int)$clientId, 'Ticket <i>creation</i> failed', 0, _SUPPORT);
	 						$this->session->set_flashdata("error_message", "Image upload failed. Make sure that the attached file meets the requirements and try again.");
	 						render("support/create_ticket.form", "client.template");
	 					}
	 					else{
		 					$ticketId = $this->support_model->addTicket($this->input->post(NULL, TRUE));
		 					if($ticketId === FALSE){
		 						$this->synthia->audit_trail((int)$clientId, 'Ticket <i>creation</i> failed', 0, _SUPPORT);
		 						$this->session->set_flashdata("error_message", "Ticket creation failed. Please try again.");
		 						render("support/create_ticket.form", "client.template");
		 					}
		 					else{
		 						$referenceNumber = $this->support_model->referenceNumber($ticketId);
		 						$this->newTicketNotification($referenceNumber);
		 						$this->synthia->audit_trail((int)$clientId, 'Ticket #<b>' . $referenceNumber . '</b> has been <i>created</i>', 1, _SUPPORT);
		 						$this->session->set_flashdata("success_message", "Ticket has been submitted successfully.");
		 						redirect(base_url() . "submitted_tickets");
		 					}
	 					}
	 				}
				}
				else{
					render("support/create_ticket.form", "client.template");
				}
			}
			else{
				render("support/create_ticket.form", "client.template");
			}
		}
		else{
			echo "ERROR 403 FORBIDDEN";
		}
	}
	
	public function ticketDetails(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$this->data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$this->data['sidebar'] = $this->load->view("sidebar/sidebar.php", $this->data, TRUE);
			
			if($this->uri->segment(1) == 'client'){
				$userId = $this->uri->segment(3);
				$username = $this->uri->segment(4);
				$ticketId = $this->uri->segment(5);
				$reference_number = $this->uri->segment(6);
				$this->data['ticket'] = $this->support_model->ticketDetails($ticketId);
				$this->data['conversation'] = $this->support_model->ticketReplies($reference_number);
				$this->data['active']['menu'] = "Clients";
				$this->data['active']['sub_menu'] = "<a href='" . base_url() . "client/clients'>Clients</a>";
				$this->data['active']['sub_menu_breadcrumb'] = " > <a href='" . base_url() . "client/clientDetails/" . $userId . "/" . $username . "'> " . $username . "</a> >
																	<a href='" . base_url() . "client/submittedTickets/" . $userId . "/" . $username . "'> Ticket History </a>  > " . $reference_number;
			}
			else{
				$ticketId = $this->uri->segment(3);
				$reference_number = $this->uri->segment(4);
				
				if($this->uri->segment(5) === "null"){
					$this->data['ticket'] = $this->support_model->guestTicketDetails($ticketId);
				}
				else{
					$this->data['ticket'] = $this->support_model->ticketDetails($ticketId);
					
				}
				$this->data['conversation'] = $this->support_model->ticketReplies($reference_number);
				
				$this->data['active']['menu'] = "Support";
				$this->data['active']['sub_menu'] = "<a href='" . base_url() . "support/tickets'>Tickets</a>";
				$this->data['active']['sub_menu_breadcrumb'] = " > # " . $reference_number;
			}
			
			render("support/ticket_details.page", "user.template", $this->data);
		}
	}
	
	public function addPriority(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$this->data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$this->data['sidebar'] = $this->load->view("sidebar/sidebar.php", $this->data, TRUE);
			if($this->input->post(NULL, TRUE)){
				if($this->support_model->addPriority($this->input->post(NULL, TRUE))){
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $this->input->post('priority_level', TRUE) . '</b> priority level has been <i>added</i>', 1, _SUPPORT);
					$this->session->set_flashdata("success_message", "Priority Level has been added successfully.");
					redirect("support/priorities");
				}
				else{
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>add</i> <b>' . $this->input->post('priority_level', TRUE) . '</b> priority level', 0, _SUPPORT);
					$this->session->set_flashdata("error_message", "Failed to add priority level.");
					redirect("support/priorities");
				}
			}
			else{
				$this->load->view("modals/add_priority_modal", $this->data);
			}
		}
	}
	
	public function deletePriority(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$this->data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$this->data['sidebar'] = $this->load->view("sidebar/sidebar.php", $this->data, TRUE);
			if($this->input->post(NULL, TRUE)){
				$priorityId = $this->input->post('priority_id', TRUE);
				$priorityName = $this->support_model->priorityName($priorityId);
				if($this->support_model->deletePriority($priorityId)){
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $priorityName . '</b> priority level has been <i>deleted</i>', 1, _SUPPORT);
					$this->session->set_flashdata("success_message", "Priority level has been successfully deleted.");
					redirect("support/priorities");
				}
				else{
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>delete</i> <b>' . $priorityName . '</b> priority level', 0, _SUPPORT);
					$this->session->set_flashdata("error_message", "Failed to delete ticket priority level.");
					redirect("support/priorities");
				}
			}
			else{
				$this->load->view("modals/delete_priority_modal", $this->data);
			}
		}
	}
	
	public function changePriorityStatus(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$this->data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$this->data['sidebar'] = $this->load->view("sidebar/sidebar.php", $this->data, TRUE);
			if($this->input->post(NULL, TRUE)){
				$priorityId = $this->input->post("id", TRUE);
				$priorityName = $this->support_model->priorityName($priorityId);
				$status = $this->support_model->priorityStatus($priorityId) == "0" ? "1" : "0";
				if($this->support_model->updatePriorityStatus($priorityId, $status)){
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $priorityName . '</b> priority level has been <i>' . ($status == '1' ? 'enabled' : 'disabled') . '</i>', 1, _SUPPORT);
					echo "TRUE";
				}
				else{
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to change the <i>status</i> of <b>' . $priorityName . '</b> priority level', 0, _SUPPORT);
					echo "FALSE";
				}
			}
			else{
				$this->load->view("modals/change_priority_status_modal", $this->data);
			}
		}
	}
	
	protected function sendToClient(string $email, string $referenceNumber, string $message, string $departmentId): bool{
		$subject = $this->support_model->ticketSubject($referenceNumber);
		$msg = "A support staff has replied to your ticket. \n \n \n" . $message;
		
		if($this->department_model->IMAPConfig($departmentId)->status == "1"){
			$departmentConfig = $this->department_model->IMAPConfig($departmentId);
			$configHost = $departmentConfig->smtp_host;
			$configUser = $departmentConfig->imap_user;
			$decryptedConfigPass = $this->encryption->decrypt($departmentConfig->imap_pass);
			$configPass = $decryptedConfigPass;
		}
		else{
			$configHost = $this->user_model->SMTPConfig()->smtp_host;
			$configUser = $this->user_model->SMTPConfig()->smtp_user;
			$decryptedConfigPass = $this->encryption->decrypt($this->user_model->SMTPConfig()->smtp_pass);
			$configPass = $decryptedConfigPass;
		}
		
		$config = array(
				'protocol' => 'smtp',
				'smtp_host' => _SMTP_PROTOCOL ."://" . $configHost,
				'smtp_port' => _SMTP_PORT,
				'smtp_user' => $configUser,
				'smtp_pass' => $configPass
		);
		
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		$this->email->from($configUser, 'Synthia Support');
		$this->email->to($email);
		
		$this->email->subject($subject);
		$this->email->message($msg);
		
		if(!$this->email->send()){
			log_message('error', $this->email->print_debugger());
			return false;
		}
		
		return true;
	}
	
	protected function sendToAssignee(string $email, string $referenceNumber, string $message): bool{
		$subject = "Support Ticket #" . $referenceNumber;
		$msg = "A client has replied. \n \n \n" . $message;
		
		$this->load->module('user');
		$configHost = $this->user_model->SMTPConfig()->smtp_host;
		$configUser = $this->user_model->SMTPConfig()->smtp_user;
		$decryptedConfigPass = $this->encryption->decrypt($this->user_model->SMTPConfig()->smtp_pass);
		$configPass = $decryptedConfigPass;
		
		$config = array(
				'protocol' => 'smtp',
				'smtp_host' => _SMTP_PROTOCOL ."://" . $configHost,
		 		'smtp_port' => _SMTP_PORT,
				'smtp_user' => $configUser,
				'smtp_pass' => $configPass
		);
		
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		$this->email->from($configUser, 'SYNTHIA - NOREPLY');
		$this->email->to($email);
		
		$this->email->subject($subject);
		$this->email->message($msg);
		
		if(!$this->email->send()){
			log_message('error', $this->email->print_debugger());
			return false;
		}
		
		return true;
	}
	
	protected function assignToStaff($email, $referenceNumber): bool{
		$subject = "Assigned Support Ticket #" . $referenceNumber;
		$msg = "A new ticket has been assigned to you. \nPlease log into your account for more details.";
		
		$this->load->module('user');
		$configHost = $this->user_model->SMTPConfig()->smtp_host;
		$configUser = $this->user_model->SMTPConfig()->smtp_user;
		$decryptedConfigPass = $this->encryption->decrypt($this->user_model->SMTPConfig()->smtp_pass);
		$configPass = $decryptedConfigPass;
		
		$config = array(
				'protocol' => 'smtp',
				'smtp_host' => _SMTP_PROTOCOL ."://" . $configHost,
		 		'smtp_port' => _SMTP_PORT,
				'smtp_user' => $configUser,
				'smtp_pass' => $configPass
		);
		
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		$this->email->from($configUser, 'SYNTHIA - NOREPLY');
		$this->email->to($email);
		
		$this->email->subject($subject);
		$this->email->message($msg);
		
		if(!$this->email->send()){
			log_message('error', $this->email->print_debugger());
			return false;
		}
		
		return true;
	}
	
	protected function newTicketNotification($referenceNumber): bool{
		$subject = "NEW Support Ticket #" . $referenceNumber;
		$msg = "A new ticket has been received. \nPlease log into your account for more details.";
		
		$adminEmails = array();
		foreach($this->support_model->adminEmails() as $admin){
			 array_push($adminEmails, $admin->email);
		}
		
		$this->load->module('user');
		$configHost = $this->user_model->SMTPConfig()->smtp_host;
		$configUser = $this->user_model->SMTPConfig()->smtp_user;
		$decryptedConfigPass = $this->encryption->decrypt($this->user_model->SMTPConfig()->smtp_pass);
		$configPass = $decryptedConfigPass;
		
		$config = array(
				'protocol' => 'smtp',
				'smtp_host' => _SMTP_PROTOCOL ."://" . $configHost,
		 		'smtp_port' => _SMTP_PORT,
				'smtp_user' => $configUser,
				'smtp_pass' => $configPass
		);
		
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		$this->email->from($configUser, 'SYNTHIA - NOREPLY');
		$this->email->to($adminEmails);
		
		$this->email->subject($subject);
		$this->email->message($msg);
		
		if(!$this->email->send()){
			log_message('error', $this->email->print_debugger());
			return false;
		}
		
		return true;
	}
	
	public function iMAPPoll(){
		$imapConfig = $this->department_model->activeIMAPConfig();
		for($i = 0; $i < sizeof($imapConfig); $i++){
			$host = $imapConfig[$i]->imap_host;
			$user = $imapConfig[$i]->imap_user;
			$pass = $imapConfig[$i]->imap_pass;
			$decryptedPass = $this->encryption->decrypt($pass);
			$this->iMAPClient($host, $user, $decryptedPass);
		}
		
		$globalConfig = $this->user_model->SMTPConfig();
		$globalHost = $globalConfig->imap_host;
		$globalUser = $globalConfig->smtp_user;
		$globalPass = $globalConfig->smtp_pass;
		$decryptedGlobalPass = $this->encryption->decrypt($globalPass);
		$this->iMAPClient($globalHost, $globalUser, $decryptedGlobalPass);
	}
	
	protected function iMAPClient($host, $user, $pass){
		// IMAP CONFIG VARS
		$config = array('host'     => $host,
						'encrypto' => _IMAP_PROTOCOL,
						'user'     => $user,
						'pass'     => $pass
		);
	
		$this->imap->imap_connect($config);
		
		$this->imap->select_folder('INBOX');
		
		//fetch all unread messages
		$email = json_encode($this->imap->get_search_messages('UNSEEN'));
	
		//work with EACH fetched email
		for($i = 0; $i < sizeOf(json_decode($email)); $i++){
			$info = json_encode($this->imap->get_message(json_decode($email)[$i]->id, TRUE));
			
			$emailSubject =  json_decode($info)->subject;
			$emailBody =  json_decode($info)->body;
			$clientEmail = json_decode($email)[$i]->from->email;
			
			//get senders client id if registered
			$clientId = @$this->support_model->userId($clientEmail);
			
			//trim email body
			$trimPosition = $this->strposa($emailBody, array("On Mon", "On Tue", "On Wed", "On Thu", "On Fri", "On Sat", "On Sun", "--"));
			$trimmedBody = substr($emailBody, 0, $trimPosition === FALSE ? strlen($emailBody) : $trimPosition);
			
			//get tickets associated with client's email
			if(isset($clientId)){
				$tickets = $this->support_model->submittedTicketsByEmail($clientEmail);
			}
			else{
				$tickets = $this->support_model->guestSubmittedTicketsByEmail($clientEmail);
			}
			
			
			//count associate ticket with the same subject as the fetched email
			$matchCount = 0;
			foreach($tickets as $ticket){
				if(trim($ticket->subject) == trim($emailSubject) || "Re: " . trim($ticket->subject) == trim($emailSubject)){
					
					if(!isset($clientId)){
						$this->support_model->guestAddReply($clientEmail, $ticket->reference_number, $trimmedBody);
					}
					else{
						$this->support_model->addReply($clientId, $ticket->reference_number, $trimmedBody);
					}
					
					$this->support_model->updateTicketStatus($ticket->id, "Open");
					var_dump($this->imap->set_unseen_message(json_decode($info)->uid, FALSE));
					//echo "A client has replied to a ticket";
					echo "2";
					$matchCount++;
				}
			}
			
			if($matchCount === 0){
				$_POST = array();
				if(!isset($clientId)){
					$_POST['guest_email'] = $clientEmail;
				}
				$_POST['subject'] = $emailSubject;
				$_POST['description'] = $trimmedBody;
				$_POST['client_id'] = $clientId;
				if($this->support_model->addTicket($_POST) === FALSE){
					echo "0";
				}
				else{// set email message from UNREAD to READ
					var_dump($this->imap->set_unseen_message(json_decode($info)->uid, FALSE));
					//echo "New ticket has been received";
					echo "1";
				}
			} 
		}
	
	}

	protected function strposa($haystack, $needle, $offset=0) {
	    if(!is_array($needle)) $needle = array($needle);
		    foreach($needle as $query) {
	    	    if(strpos($haystack, $query, $offset) !== false) return strpos($haystack, $query, $offset); // stop on first true result
	    	}
    	return false;
	}
	
}
?>