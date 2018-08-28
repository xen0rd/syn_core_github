<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Synthia Class
 * @author	Grizzlysts - Dean Manalo
 * @since 2017
 * @version	1.0.0
 */
class Synthia {
	protected $CI;
	
	public function __construct(){
		$this->CI =& get_instance();
	}
	
	/**
	 * Inserts audit logs to database
	 * @param int $userId
	 * @param string $log
	 * @param int $status
	 * @param string $moduleName
	 * @return bool
	 */
	public function audit_trail(int $userId, string $log, int $status, string $moduleName): bool{
		$sql = "INSERT INTO audit_trail (log, status, user_id, module_name) VALUES (?, ?, ?, ?)";
		$query = $this->CI->db->query($sql, array($log, $status, $userId, $moduleName));
		return $this->CI->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	/**
	 * Fetches activity logs
	 * @return string[]
	 */
	public function activities(){
		$sql = "SELECT a.*, b.first_name, b.last_name FROM audit_trail a LEFT JOIN user b ON a.user_id = b.id ORDER BY id DESC LIMIT 100";
		$query = $this->CI->db->query($sql);
		return $query->result();
	}
	
}
?>