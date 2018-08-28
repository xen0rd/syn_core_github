<?php
/**
 *
 * @author Dean Manalo
 * @version User_model 1.0.0
 *
 */
class User_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function username($userId){
		$sql = "SELECT username FROM user WHERE id = ?";
		$query = $this->db->query($sql, $userId);
		return $query->num_rows() > 0 ? $query->row()->username : FALSE;
	}
	
	public function usersInfo(){
		$sql = "SELECT a.*, b.role_name, c.department_name, d.security_question, e.country_name, f.theme_name
				FROM user a
				LEFT JOIN role b ON a.role_id = b.id
				LEFT JOIN department c ON a.department_id = c.id
				LEFT JOIN security_question d ON a.security_question_id = d.id
				LEFT JOIN country e ON a.country_code = e.code
				LEFT JOIN admin_theme f ON a.admin_theme_id = f.id WHERE a.role_id != ?";
		$query = $this->db->query($sql, 3);
		return $query->num_rows() > 0 ? $query->result() : false;
	}
	
	public function updateUserStatus($userId, $status){
		$sql = "UPDATE user SET is_active = ? WHERE id = ?";
		$query = $this->db->query($sql, array($status, $userId));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function userStatus($userId){
		$sql = "SELECT is_active FROM user WHERE id = ?";
		$query = $this->db->query($sql, array($userId));
		return $query->row()->is_active;
	}
	
	public function roles(){
		$sql = "SELECT * FROM role";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function adminSkin(string $username){
		$sql = "SELECT admin_theme_id FROM user WHERE username = ?";
		$query = $this->db->query($sql, array($username));
		return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function updateSkin(string $username, string $skin){
		$sql = "UPDATE user SET admin_theme_id = ? WHERE username = ?";
		$query = $this->db->query($sql, array($skin, $username));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function updateSMTPConfig(string $smtpHost, string $user, string $pass, string $imapHost): bool{
		$sql = "UPDATE server_config SET smtp_host = ?, smtp_user = ?, smtp_pass = ?, imap_host = ? WHERE environment = ?";
		$query = $this->db->query($sql, array($smtpHost, $user, $pass, $imapHost, _ENVIRONMENT));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function SMTPConfig(){
		$sql = "SELECT * FROM server_config WHERE environment = ?";
		$query = $this->db->query($sql, array(_ENVIRONMENT));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function title(){
		$sql = "SELECT app_name FROM server_config WHERE environment = ?";
		$query = $this->db->query($sql, array(_ENVIRONMENT));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function logo(){
		$sql = "SELECT logo FROM server_config WHERE environment = ?";
		$query = $this->db->query($sql, array(_ENVIRONMENT));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function updateLogo($logo){
		$sql = "UPDATE server_config SET logo = ? WHERE environment = ?";
		$query = $this->db->query($sql, array($logo, _ENVIRONMENT));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function miniLogo(){
		$sql = "SELECT mini_logo FROM server_config WHERE environment = ?";
		$query = $this->db->query($sql, array(_ENVIRONMENT));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function updateMiniLogo($miniLogo){
		$sql = "UPDATE server_config SET mini_logo = ? WHERE environment = ?";
		$query = $this->db->query($sql, array($miniLogo, _ENVIRONMENT));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}

        public function paymentMethod(){
            $sql = "SELECT * FROM payment_method";
            $query = $this->db->query($sql);
            return $query->row();
        }
        
        public function addPaymentMethod($businessEmail, $identityToken){
            $sql = "UPDATE payment_method SET business_email = ?, identity_token = ?";
            $query = $this->db->query($sql, array($businessEmail, $identityToken));
            return $this->db->affected_rows() > 0 ? TRUE : FALSE;
        }
}
?>