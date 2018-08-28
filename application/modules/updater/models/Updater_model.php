<?php
/**
 *
 * @author Dean Manalo
 * @version Updater_model 1.0.0
 *
 */
class Updater_model extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	//Returns a single row with encrypted license data
	public function accountInfo(){
		$sql = "SELECT * FROM license";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->row()->license : false;
	}
}