<?php
/**
 *
 * @author Dean Manalo
 * @version Department 1.0.0
 *
 */
class Department extends MX_Controller{
	private $data;
	
	public function __construct(){
		parent::__construct();
		$this->load->module("user");
		$this->load->model("department_model");
		
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		
		$this->data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
		$this->data['sidebar'] = $this->load->view("sidebar/sidebar.php", $this->data, TRUE);
	}
	
	public function index(){
		if($this->session->userdata("u_role") != "admin"){
			echo "403 Forbidden";
		}
		else{
			$this->data['active']['menu'] = "Departments";
			render("departments.page", "user.template", $this->data);
		}
	}
	
	public function getDepartments(){
		echo json_encode(array("data" => $this->department_model->departments()));
	}
	
	public function getDepartmentMembers(){
		$departmentId = $this->input->post("department_id");
		echo json_encode($this->department_model->departmentMembers($departmentId));
	}
	
	public function deleteDepartment(){
		if($this->input->post(NULL, TRUE)){
			$departmentId = $this->input->post('department_id', TRUE);
			$departmentName = $this->department_model->departmentName($departmentId);
			if($this->department_model->deleteDepartment($departmentId)){
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $departmentName . '</b> department has been <i>deleted</i>', 1, _DEPARTMENT);
				$this->session->set_flashdata("success_message", "Department has been successfully deleted.");
				redirect("departments");
			}
			else{
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>delete</i> <b>' . $departmentName . '</b> department', 0, _DEPARTMENT);
				$this->session->set_flashdata("error_message", "Failed to delete department.");
				redirect("departments");
			}
		}
		else{
			$this->load->view("modals/delete_department_modal", $this->data);
		}
	}
	
	public function addDepartment(){
		if($this->input->post(NULL, TRUE)){
			if($this->department_model->addDepartment($this->input->post(NULL, TRUE))){
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $this->input->post('department_name', TRUE) . '</b> department has been <i>added</i>', 1, _DEPARTMENT);
				$this->session->set_flashdata("success_message", "Department has been successfully added.");
				redirect("departments");
			}
			else{
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>add</i> <b>' . $this->input->post('department_name', TRUE) . '</b> department', 0, _DEPARTMENT);
				$this->session->set_flashdata("error_message", "Failed to add new department.");
				redirect("departments");
			}
		}
		else{
			$this->load->view("modals/add_department_modal", $this->data);
		}
	}
	
	public function changeStatus(){
		if($this->input->post(NULL, TRUE)){
			$departmentId = $this->input->post("id", TRUE);
			$departmentName = $this->department_model->departmentName($departmentId);
			$status = $this->department_model->departmentStatus($departmentId) == "0" ? "1" : "0";
			if($this->department_model->updateStatus($departmentId, $status)){
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $departmentName . '</b> department has been <i>' . ($status == '1' ? 'enabled' : 'disabled') . '</i>', 1, _DEPARTMENT);
				echo "TRUE";
			}
			else{
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to change the <i>status</i> of <b>' . $departmentName . '</b> department', 0, _DEPARTMENT);
				echo "FALSE";	
			}
		}
		else{
			$this->load->view("modals/change_department_status_modal", $this->data);
		}
	}
	
	
	public function changeIMAPSettings(){
		if($this->input->post(NULL, TRUE)){
			$departmentId = $this->input->post("id", TRUE);
			$departmentName = $this->department_model->departmentName($departmentId);
			$status = $this->department_model->departmentStatus($departmentId) == "0" ? "1" : "0";
			if($this->department_model->updateStatus($departmentId, $status)){
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $departmentName . '</b> department has been <i>' . ($status == '1' ? 'enabled' : 'disabled') . '</i>', 1, _DEPARTMENT);
				echo "TRUE";
			}
			else{
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to change the <i>status</i> of <b>' . $departmentName . '</b> department', 0, _DEPARTMENT);
				echo "FALSE";	
			}
		}
		else{
			$this->load->view("modals/change_department_status_modal", $this->data);
		}
	}
	
	
	
	public function IMAPConfiguration(){
		if(!$this->auth->isUserLoggedIn()){
			redirect('admin');
		}
		else{
			if($this->input->post(NULL, TRUE)){
				$departmentName = $this->department_model->departmentName($this->input->post('department_id', TRUE));
				$hashedIMAPPassword = $this->encryption->encrypt($this->input->post('imap_pass', TRUE));
				$_POST['imap_pass'] = $hashedIMAPPassword;
				if($this->input->post("status", TRUE) == 1){
					$smtpHost = $this->input->post("smtp_host", TRUE);
					$imapHost = $this->input->post("imap_host", TRUE);
					$user = $this->input->post("imap_user", TRUE);
					$pass = $this->input->post("imap_pass", TRUE);
					$status = $this->input->post("status", TRUE);
					$departmentId = $this->input->post("department_id", TRUE);
					if($this->department_model->addIMAPConfig($smtpHost, $imapHost, $user, $pass, $status, $departmentId)){
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'IMAP configuration for <b>' . $departmentName . '</b> department has been <i>updated</i>', 1, _DEPARTMENT);
						$this->session->set_flashdata('success_message', 'IMAP configuration has been updated');
						redirect('departments');
					}
					else{
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> IMAP configuration for <b>' . $departmentName . '</b> department', 0, _DEPARTMENT);
						$this->session->set_flashdata('error_message', 'Failed to update IMAP configuration');
						redirect('departments');
					}
				}
				else if($this->input->post("status", TRUE) == 0){
					if($this->department_model->updateIMAPConfig($this->input->post("status", TRUE), $this->input->post('department_id', TRUE))){
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'IMAP configuration for <b>' . $departmentName . '</b> department has been <i>set</i> to use <b>global settings</b>', 1, _DEPARTMENT);
						$this->session->set_flashdata('success_message', 'IMAP configuration has been updated');
						redirect('departments');
					}
					else{
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>change</i> IMAP configuration for <b>' . $departmentName . '</b> department', 0, _DEPARTMENT);
						$this->session->set_flashdata('error_message', 'Failed to change IMAP configuration');
						redirect('departments');
					}
				}
			}
			else{
				$data['imap'] = $this->department_model->IMAPConfig($this->uri->segment(3));
				$this->load->view('modals/imap_settings_modal', $data);
			}
		}
	}
	
}
?>