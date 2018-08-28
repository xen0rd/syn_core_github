<?php
class Activity extends MX_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->module('user');
	}
	
	public function getActivities(){
		if(!$this->auth->isUserLoggedIn()){
			redirect('user');
		}
		else{
			if($this->session->userdata("u_role") != "admin"){
				echo "403 Forbidden";
			}
			else{
				$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
				$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
				
				$data['active']['menu'] = "Activities";
				$data['active']['sub_menu'] = "*Showing only last 100 logs";
				$data['activities'] = $this->synthia->activities();
				render('activities.page', 'user.template', $data);
			}
		}
	}
	
}
?>