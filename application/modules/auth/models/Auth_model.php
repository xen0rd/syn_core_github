<?php
/**
 *
 * @author Dean Manalo
 * @version Auth_model 1.0.0
 *
 */
class Auth_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * Inserts registration data to USER table
	 * @param unknown $postData
	 */
	public function addUser($postData): bool{
		$this->db->insert("user", $postData);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	/**
	 * Returns the user's information of the given argument
	 * @param string $username
	 * @return mixed
	 */
	public function userInfo(string $username){
		$sql = "SELECT a.*, b.role_name, c.department_name, d.security_question, e.country_name, f.theme_name
				FROM user a
				LEFT JOIN role b ON a.role_id = b.id 
				LEFT JOIN department c ON a.department_id = c.id  
				LEFT JOIN security_question d ON a.security_question_id = d.id  
				LEFT JOIN country e ON a.country_code = e.code
				LEFT JOIN admin_theme f ON a.admin_theme_id = f.id
				WHERE username = ?";
		$query = $this->db->query($sql,$username);
		return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function userInfoEmail(string $email){
		$sql = "SELECT * FROM user WHERE email = ?";
		$query = $this->db->query($sql, $email);
		return $query->num_rows() > 0 ? true : false;
	}
	
	/**
	 * Updates the user's password
	 * @param string $username
	 * @param string $newPassword
	 * @return bool
	 */
	public function updatePassword(string $username, string $newPassword): bool{
		$sql = "UPDATE user SET password = ?, new_password_key = ?, new_password_request = ? WHERE username = ?";
		$query = $this->db->query($sql, array($newPassword, null, null, $username));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function updateLastClientIP(string $username, $remoteIP){
		$sql = "UPDATE user SET last_ip = ?, last_login = NOW() WHERE username = ?";
		$query = $this->db->query($sql, array($remoteIP, $username));
	}
	
	public function updateEmailKey(string $username, string $key){
		$sql = "UPDATE user SET new_email_key = ? WHERE username = ?";
		$query = $this->db->query($sql, array($key, $username));
	}
	
	public function updatePasswordKey(string $username, string $key){
		$sql = "UPDATE user SET new_password_key = ?, new_password_request = NOW() WHERE username = ?";
		$query = $this->db->query($sql, array($key, $username));
	}
	
	public function passwordKey(string $username){
		$sql = "SELECT new_password_key FROM user WHERE username = ? AND new_password_request < DATE_SUB(NOW(), INTERVAL -12 HOUR)";
		$query = $this->db->query($sql, array($username));
		return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function updateEmail(string $username, string $key): bool{
		$sql = "UPDATE user SET email = new_email,
							new_email = ?,
							new_email_key = ?,
							is_active = ?
							WHERE username = ? AND new_email_key = ?";
		$query = $this->db->query($sql, array(null, null, 1, $username, $key));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function updateUserInfo($postData, string $username): bool{
		$this->db->where("username", $username);
		$this->db->update("user", $postData);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function deleteUserPendingEmail(string $username): bool{
		$sql = "UPDATE user SET new_email = ?, new_email_key = ? WHERE username = ?";
		$query = $this->db->query($sql, array(null, null, $username));
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function securityAnswer(string $username){
		$sql = "SELECT security_answer FROM user WHERE username = ?";
		$query = $this->db->query($sql, array($username));
		return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	
}
?>