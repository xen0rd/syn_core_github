<?php
/**
 *
 * @author Dean Manalo
 * @version Client_model 1.0.0
 *
 */
class Client_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	
	public function clientsInfo(){
		$sql = "SELECT a.*, b.role_name, c.department_name, d.security_question, e.country_name, f.theme_name
				FROM user a
				LEFT JOIN role b ON a.role_id = b.id
				LEFT JOIN department c ON a.department_id = c.id
				LEFT JOIN security_question d ON a.security_question_id = d.id
				LEFT JOIN country e ON a.country_code = e.code
				LEFT JOIN admin_theme f ON a.admin_theme_id = f.id WHERE a.role_id = ?";
		$query = $this->db->query($sql, 3);
		return $query->num_rows() > 0 ? $query->result() : false;
	}
	
	public function username($userId){
		$sql = "SELECT username FROM user WHERE id = ?";
		$query = $this->db->query($sql, $userId);
		return $query->num_rows() > 0 ? $query->row()->username : FALSE;
	}
	
	public function updateClientStatus($userId, $status){
		$sql = "UPDATE user SET is_active = ? WHERE id = ?";
		$query = $this->db->query($sql, array($status, $userId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function clientStatus($userId){
		$sql = "SELECT is_active FROM user WHERE id = ?";
		$query = $this->db->query($sql, array($userId));
		return $query->row()->is_active;
	}
	
}
?>