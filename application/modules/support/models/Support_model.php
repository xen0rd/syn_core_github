<?php
/**
 *
 * @author Dean Manalo
 * @version Support_model 1.0.0
 *
 */
class Support_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function tickets(){
		$sql = "SELECT a.*, b.priority_level FROM ticket a LEFT JOIN ticket_priority b ON a.priority_level = b.id";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function activeTickets(){
		$sql = "SELECT a.*, b.priority_level FROM ticket a LEFT JOIN ticket_priority b ON a.priority_level = b.id WHERE a.status != ?";
		$query = $this->db->query($sql, array("Closed"));
		return $query->result();
	}
	
	public function assignedTickets($userId){
		$sql = "SELECT a.*, b.priority_level FROM ticket a LEFT JOIN ticket_priority b ON a.priority_level = b.id WHERE a.assignee_id = ?";
		$query = $this->db->query($sql, array($userId));
		return $query->result();
	}
	
	public function assignedActiveTickets($userId){
		$sql = "SELECT a.*, b.priority_level FROM ticket a LEFT JOIN ticket_priority b ON a.priority_level = b.id WHERE a.assignee_id = ? AND a.status != ?";
		$query = $this->db->query($sql, array($userId, "Closed"));
		return $query->result();
	}
	
	public function updateTicketStatus($ticketId, $status){
		$sql = "UPDATE ticket SET status = ? WHERE id = ?";
		$query = $this->db->query($sql, array($status, $ticketId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function updateAssignedTicket($assigneeId, $ticketId){
		$sql = "UPDATE ticket SET assignee_id = ? WHERE id = ?";
		$query = $this->db->query($sql, array($assigneeId, $ticketId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
		
	public function submittedTickets($clientId){
		$sql = "SELECT * FROM ticket WHERE client_id = ? ORDER BY date_created DESC";
		$query = $this->db->query($sql, array($clientId));
		return $query->result();
	}
	
	public function submittedTicketsByEmail($email){
		$sql = "SELECT a.*, b.email FROM ticket a LEFT JOIN user b ON a.client_id = b.id WHERE b.email = ?";
		$query = $this->db->query($sql, array($email));
		return $query->num_rows() > 0 ? $query->result() : NULL;
	}
	
	public function guestSubmittedTicketsByEmail($email){
		$sql = "SELECT * FROM ticket WHERE guest_email = ?";
		$query = $this->db->query($sql, array($email));
		return $query->result();
	}
	
	public function priorities(){
		$sql = "SELECT * FROM ticket_priority";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function activePriorities(){
		$sql = "SELECT * FROM ticket_priority WHERE status = ?";
		$query = $this->db->query($sql, array("1"));
		return $query->result();
	}
	
	public function addPriority($postData){
		$this->db->insert("ticket_priority", $postData);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function addReply($userId, $referenceNumber,$message){
		$sql = "INSERT INTO ticket_reply (user_id, ticket_reference_number, message) VALUES (?, ?, ?)";
		$query = $this->db->query($sql, array($userId, $referenceNumber, $message));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function guestAddReply($email, $referenceNumber,$message){
		$sql = "INSERT INTO ticket_reply (guest_email, ticket_reference_number, message) VALUES (?, ?, ?)";
		$query = $this->db->query($sql, array($email, $referenceNumber, $message));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function deletePriority(string $priorityId){
		$sql = "DELETE FROM ticket_priority WHERE id = ?";
		$query = $this->db->query($sql, array($priorityId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function updatePriorityStatus($priorityId, $status){
		$sql = "UPDATE ticket_priority SET status = ? WHERE id = ?";
		$query = $this->db->query($sql, array($status, $priorityId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function priorityStatus($priorityId){
		$sql = "SELECT status FROM ticket_priority WHERE id = ?";
		$query = $this->db->query($sql, array($priorityId));
		return $query->row()->status;
	}
	
	public function clientId($username){
		$sql = "SELECT id FROM user WHERE username = ?";
		$query = $this->db->query($sql, array($username));
		return $query->row()->id;
	}
	
	public function ticketDetails($ticketId){
		$sql = "SELECT a.id,
				a.reference_number,
				a.subject,
				a.description,
				a.status,
				a.date_created,
				a.attachment,
				a.assignee_id,
				a.priority_level as priority_id,
				b.first_name as client_first_name,
				b.last_name as client_last_name,
				b.email as client_email,
				c.first_name as assignee_first_name,
				c.last_name as assignee_last_name,
				c.email as assignee_email,
				d.priority_level, e.department_name,
				e.id as department_id
				FROM ticket a INNER JOIN user b ON a.client_id = b.id
				LEFT JOIN user c ON a.assignee_id = c.id
				LEFT JOIN ticket_priority d ON a.priority_level = d.id
				LEFT JOIN department e ON c.department_id = e.id
				WHERE a.id = ?";
		$query = $this->db->query($sql, array($ticketId));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function guestTicketDetails($ticketId){
		$sql = "SELECT a.id,
				a.reference_number,
				a.subject,
				a.description,
				a.status,
				a.date_created,
				a.attachment,
				a.assignee_id,
				a.priority_level as priority_id,
				a.guest_email as client_first_name,
				c.first_name as assignee_first_name,
				c.last_name as assignee_last_name,
				c.email as assignee_email,
				d.priority_level, e.department_name,
				e.id as department_id
				FROM ticket a
				LEFT JOIN user c ON a.assignee_id = c.id
				LEFT JOIN ticket_priority d ON a.priority_level = d.id
				LEFT JOIN department e ON c.department_id = e.id
				WHERE a.id = ?";
		$query = $this->db->query($sql, array($ticketId));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function ticketReplies($reference_number){
		$sql = "SELECT a.*, b.first_name, b.last_name FROM ticket_reply a LEFT JOIN user b ON a.user_id = b.id WHERE a.ticket_reference_number = ? ORDER BY a.date_created DESC";
		$query = $this->db->query($sql, array($reference_number));
		return $query->result();
	}
	
	/* public function guestTicketReplies($reference_number){
		$sql = "SELECT * FROM ticket_reply WHERE ticket_reference_number = ? ORDER BY date_created DESC";
		$query = $this->db->query($sql, array($reference_number));
		return $query->result();
	} */
	
	public function addTicket($postData){
		$this->db->insert("ticket", $postData);
		return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
	}
	
	public function deleteTicket(string $ticketNumber){
		$sql = "DELETE FROM ticket WHERE id = ?";
		$query = $this->db->query($sql, array($ticketNumber));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function updateTicketPriorityLevel($ticketId, $priorityLevel){
		$sql = "UPDATE ticket SET priority_level = ? WHERE id = ?";
		$query = $this->db->query($sql, array($priorityLevel, $ticketId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function addAttachment(string $fileName): bool{
		$sql = "UPDATE ticket (attachment) VALUES ? WHERE id = last_insert_id()";
		$query = $this->db->query($sql, array($fileName));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function referenceNumber($ticketId){
		$sql = "SELECT reference_number FROM ticket WHERE id = ?";
		$query = $this->db->query($sql, array($ticketId));
		return $query->row()->reference_number;
	}
	
	public function priorityName($priorityId){
		$sql = "SELECT priority_level FROM ticket_priority WHERE id = ?";
		$query = $this->db->query($sql, array($priorityId));
		return $query->row()->priority_level;
	}
	
	public function adminEmails(){
		$sql = "SELECT email FROM user WHERE role_id = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result();
	}
	
	public function assigneeEmail($assigneeId){
		$sql = "SELECT email FROM user WHERE id = ?";
		$query = $this->db->query($sql, array($assigneeId));
		return $query->row()->email;
	}
	
	public function assigneeName($assigneeId){
		$sql = "SELECT first_name, last_name FROM user WHERE id = ?";
		$query = $this->db->query($sql, array($assigneeId));
		return $query->row()->first_name . " " . $query->row()->last_name;
	}
	
	public function userId($email){
		$sql = "SELECT id FROM user WHERE email = ?";
		$query = $this->db->query($sql, array($email));
		return $query->row()->id;
	}
	
	public function ticketLatestReply($reference_number){
		$sql = "SELECT MAX(date_created) as date FROM ticket_reply WHERE ticket_reference_number = ?";
		$query = $this->db->query($sql, array($reference_number));
		return $query->row();
	}
	
	public function ticketSubject($referenceNumber){
		$sql = "SELECT subject FROM ticket WHERE reference_number = ?";
		$query = $this->db->query($sql, array($referenceNumber));
		return $query->row()->subject;
	}
	
}
?>