<?php
/**
 *
 * @author Dean Manalo
 * @version Department_model 1.0.0
 *
 */
class Department_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function departments(){
		$sql = "SELECT * FROM department";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function departmentName($departmentId){
		$sql = "SELECT department_name FROM department WHERE id = ?";
		$query = $this->db->query($sql, array($departmentId));
		return $query->row()->department_name;
	}
	
	public function activeDepartments(){
		$sql = "SELECT * FROM department WHERE status = ?";
		$query = $this->db->query($sql, array("1"));
		return $query->result();
	}
	
	public function departmentMembers($departmentId){
		$sql = "SELECT a.username, a.first_name, a.last_name, a.id FROM user a INNER JOIN department b ON a.department_id = b.id WHERE b.id = ?";
		$query = $this->db->query($sql, array($departmentId));
		return $query->result();
	}
	
	public function deleteDepartment(string $departmentId){
		$sql = "DELETE FROM department WHERE id = ?";
		$query = $this->db->query($sql, array($departmentId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function addDepartment($postData){
		$this->db->insert("department", $postData);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function updateStatus($departmentId, $status){
		$sql = "UPDATE department SET status = ? WHERE id = ?";
		$query = $this->db->query($sql, array($status, $departmentId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function departmentStatus($departmentId){
		$sql = "SELECT status FROM department WHERE id = ?";
		$query = $this->db->query($sql, array($departmentId));
		return $query->row()->status;
	}
	
	public function IMAPConfig($departmentId){
		$sql = "SELECT * FROM department_imap WHERE department_id = ?";
		$query = $this->db->query($sql, array($departmentId));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function activeIMAPConfig(){
		$sql = "SELECT * FROM department_imap WHERE status = ?";
		$query = $this->db->query($sql, array("1"));
		return $query->result();
	}
	
	public function addIMAPConfig($smtpHost, $imapHhost, $user, $pass, $status, $departmentId){
		$sql = "INSERT INTO department_imap (department_id, smtp_host, imap_host, imap_user, imap_pass, status)
				VALUES (?,?,?,?,?,?)
				ON DUPLICATE KEY UPDATE smtp_host = ?, imap_host = ?, imap_user = ?, imap_pass = ?, status = ?";
		$query = $this->db->query($sql, array($departmentId, $smtpHost, $imapHhost, $user, $pass, $status, $smtpHost, $imapHhost, $user, $pass, $status));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function updateIMAPConfig($status, $departmentId){
		$sql = "UPDATE department_imap SET status = ? WHERE department_id = ?";
		$query = $this->db->query($sql, array($status, $departmentId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	
}