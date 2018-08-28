<?php
/**
 *
 * @author Dean Manalo
 * @version Client 1.0.0
 *
 */
class Client extends MX_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->module('auth');
		$this->load->module('user');
		$this->load->module('product');
		$this->load->model('client_model');
	}
	
	public function index(){
		$this->session->set_flashdata('referrer', current_url());
		//$data['products'] = $this->product_model->products();
		$data['cart'] = @$_SESSION['cart_item'];
                $data['payment_method'] = $this->user_model->paymentMethod();
		$data['shopping_cart'] = $this->load->view('product/shopping_cart.page.php', $data, TRUE);
		
                if($this->uri->segment(1) == 'downloadable'){
                    $data['products'] = $this->product_model->downloadableProducts();    
                }
                else if($this->uri->segment(1) == 'virtual'){
                    $data['products'] = $this->product_model->virtualProducts();    
                }
                
                render("product_list.page", "client.template", $data);
	}
	
	public function clients(){
		if(!$this->auth->isUserLoggedIn()){
			render("login", "default.template");
		}
		else{
			if($this->session->userdata("u_role") != "admin"){
				echo "403 Forbidden";
			}
			else{
				$data['active']['menu'] = "Clients";
				$data['active']['sub_menu'] = "Clients";
				$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
				$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
				render("clients_list.page", "user.template", $data);
			}
		}
	}
	
	public function getClients(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			if($this->session->userdata("u_role") != "admin"){
				echo "403 Forbidden";
			}
			else{
				echo json_encode(array("data" => $this->client_model->clientsInfo()));
			}
		}
	}
	
	public function clientDetails(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			if($this->session->userdata("u_role") != "admin"){
				echo "403 Forbidden";
			}
			else{
				if($this->input->post(NULL, TRUE)){
					if($this->form_validation->run('admin_change_client_password')){
						$userId = $this->input->post("user_id", TRUE);
						$username = $this->input->post("username", TRUE);
						$newPassword = $this->input->post('new_password', TRUE);
						$hashedPassword = $this->bcrypt->hash_password($newPassword);
						if($this->auth_model->updatePassword($username, $hashedPassword)){
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), '<b>' . $username . '</b>&quot;s password has been <i>updated</i>', 1, _CLIENT);
							$this->session->set_flashdata('success_message', 'Password change successful');
							redirect(base_url() . 'client/clientDetails/' . $userId . '/' . $username);
						}
						else{
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> <b>' . $username . '</b>&quot;s password', 0, _CLIENT);
							$this->session->set_flashdata('error_message', 'Failed to update your password');
							redirect(base_url() . 'client/clientDetails/' . $userId . '/' . $username);
						}
					}
					else{
						$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
						$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
						$userId = $this->uri->segment(3);
						$username = $this->uri->segment(4);
			
						$data['clientDetails'] = $this->auth_model->userInfo($username);
							
						$data['active']['menu'] = "Clients";
						$data['active']['sub_menu'] = "<a href='" . base_url() . "client/clients'>Clients</a>";
						$data['active']['sub_menu_breadcrumb'] = " > " . $username;
							
						render("client/client_details.page", "user.template", $data);
					}
				}
				else{
					$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
					$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
					$userId = $this->uri->segment(3);
					$username = $this->uri->segment(4);
						
					$data['clientDetails'] = $this->auth_model->userInfo($username);
						
					$data['active']['menu'] = "Clients";
					$data['active']['sub_menu'] = "<a href='" . base_url() . "client/clients'>Clients</a>";
					$data['active']['sub_menu_breadcrumb'] = " > " . $username;
						
					render("client/client_details.page", "user.template", $data);
				}
			}
		}
	}
	
	public function register(){
		if($this->input->post(NULL, TRUE)){
			if($this->form_validation->run('add_client')){
				unset($_POST['confirm_password']);
				
				$_POST['department_id'] = 1;
				$_POST['role_id'] = 3;
				$_POST['date_of_birth'] = date_format(new DateTime($this->input->post('date_of_birth')), 'Y-m-d');
				$_POST['password'] = $this->bcrypt->hash_password($this->input->post('password', TRUE));
				$_POST['security_answer'] = $this->encryption->encrypt($this->input->post('security_answer', TRUE));
				if($this->auth_model->addUser($this->input->post(NULL, TRUE))){
					if($this->auth->sendEmailVerification($this->input->post('username', TRUE))){
						$this->session->set_flashdata("success_message", "Registration successful");
						redirect("client");
					}
					else{
						$this->session->set_flashdata("info_message", "Registration succeeded but we failed to send an email verification code. Please contact support to activate your account.");
						redirect("client");
					}
				}
				else{
					$this->session->set_flashdata("error_message", "Failed to register account");
					redirect("client");
				}
			}
			else{
				render("client/registration.form", "client.template");
			}
		}
		else{
			render("client/registration.form", "client.template");
		}
	}
	
	public function forgotPassword(){
		if($this->input->post(NULL, TRUE)){
			if($this->form_validation->run('forgot_password')){
				$username = $this->input->post('username', TRUE);
				$data['username'] = $username;
				$data['security_question'] = $this->auth_model->userInfo($username)->security_question;
				render("auth/security_question.form", "client.template", $data);
			}
			else{
				render("auth/forgot_password.form", "client.template");
			}
		}
		else{
			render("auth/forgot_password.form", "client.template");
		}
	}
	
	public function changePassword(){
		if($this->auth->isClientLoggedIn()){
			if($this->input->post(NULL, TRUE)){
				if($this->form_validation->run('change_client_password')){
					$username = $this->session->userdata('c_username');
					$newPassword = $this->input->post('new_password');
					$hashedPassword = $this->bcrypt->hash_password($newPassword);
					if($this->auth_model->updatePassword($username, $hashedPassword)){
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Password has been <i>updated</i>', 1, _CLIENT);
						$this->session->set_flashdata('success_message', 'Password change successful');
						redirect(current_url());
					}
					else{
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> password', 0, _CLIENT);
						$this->session->set_flashdata('error_message', 'Failed to update your password');
						redirect(current_url());
					}
				}
				else{
					render('client/change_password.form', 'client.template');
				}
			}
			else{
				render('client/change_password.form', 'client.template');
			}
		}
		else{
			echo "ERROR 403 FORBIDDEN";
		}
	}

	public function profileSettings(){
		if($this->auth->isClientLoggedIn()){
			$username = $this->session->userdata('c_username');
			
			if($this->input->post(NULL, TRUE)){
				if($this->form_validation->run('profile_settings')){
					unset($_POST['first_name']);
					unset($_POST['last_name']);
					unset($_POST['date_of_birth']);
					if($this->auth_model->updateUserInfo($this->input->post(NULL, TRUE), $username)){
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Profile has been <i>updated</i>', 1, _CLIENT);
						$this->session->set_flashdata('success_message', 'Your profile has been successfully updated');
						redirect(current_url());
					}
					else{
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> profile', 0, _CLIENT);
						$this->session->set_flashdata('info_message', 'No changes were made');
						redirect(current_url());
					}
				}
				else{
					$data['userInfo'] = $this->auth_model->userInfo($username);
					render('client/profile_settings.form', 'client.template', $data);
				}
			}
			else{
				$data['userInfo'] = $this->auth_model->userInfo($username);
				render('client/profile_settings.form', 'client.template', $data);
			}
		}
		else{
			echo "ERROR 403 FORBIDDEN";
		}	
	}
	
	public function accountSettings(){
		if($this->auth->isClientLoggedIn()){
			$username = $this->session->userdata('c_username');
			
			if($this->input->post(NULL, TRUE)){
				if($this->form_validation->run('account_settings')){
					unset($_POST['username']);
					$currentEmail = $this->auth_model->userInfo($username)->email;
					 
					if($currentEmail == $this->input->post('new_email', TRUE)){
						unset($_POST['new_email']);
						$_POST['security_answer'] = $this->encryption->encrypt($this->input->post('security_answer', TRUE));
						if($this->auth_model->updateUserInfo($this->input->post(NULL, TRUE), $username)){
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Account details has been <i>updated</i>', 1, _CLIENT);
							$this->session->set_flashdata('success_message', 'Your account details has been updated');
							redirect(current_url());
						}
						else{
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> account details', 0, _CLIENT);
							$this->session->set_flashdata('error_message', 'Failed to update your account details');
							redirect(current_url());
						}
					}
					else{
						$_POST['security_answer'] = $this->encryption->encrypt($this->input->post('security_answer', TRUE));
						if($this->auth_model->updateUserInfo($this->input->post(NULL, TRUE), $username)){
							if($this->auth->sendEmailVerification($username)){
								$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Account details has been <i>updated</i>', 1, _USER);
								$this->session->set_flashdata('success_message', 'An email has been sent to you. Please check your email and follow the link to verify your new email address');
							}
							else{
								$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>send</i> email verification code', 0, _USER);
								$this->session->set_flashdata('error_message', 'Failed to send email verification code. Please contact the administrator.');
							}
							redirect(current_url());
						}
						else{
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> account details', 0, _CLIENT);
							$this->session->set_flashdata('error_message', 'Failed to update your account details');
							redirect(current_url());
						}
					}
					
				}
				else{
					$data['userInfo'] = $this->auth_model->userInfo($username);
					render('client/account_settings.form', 'client.template', $data);
				}
			}
			else{
				$data['userInfo'] = $this->auth_model->userInfo($username);
				render('client/account_settings.form', 'client.template', $data);
			}
		}
		else{
			echo "ERROR 403 FORBIDDEN";
		}	
	}
	
	public function removePendingEmail(){
		if($this->auth->isClientLoggedIn()){
			$username = $this->session->userdata('c_username');
			if($this->auth_model->deleteUserPendingEmail($username)){
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Pending email has been <i>removed</i>', 1, _CLIENT);
				$this->session->set_flashdata('success_message', 'Pending email has been removed');
				redirect("account_settings");
			}else{
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>remove</i> pending email', 0, _CLIENT);
				$this->session->set_flashdata('error_message', 'Failed to remove pending email');
				redirect("account_settings");
			}
		}
		else{
			echo "ERROR 403 FORBIDDEN";
		}
			
	}
	
	public function changeClientStatus(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
			if($this->input->post(NULL, TRUE)){
				$userId = $this->input->post("id", TRUE);
				$username = $this->client_model->username($userId);
				$status = $this->client_model->clientStatus($userId) == 0 ? 1 : 0;
				if($this->client_model->updateClientStatus($userId, $status)){
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Client <b>' . $username . '</b> has been <i>' . ($status == '1' ? 'enabled' : 'disabled') . '</i>', 1, _CLIENT);
					echo "TRUE";
				}
				else{
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to change the <i>status</i> of client <b>' . $username . '</b>', 0, _CLIENT);
					echo "FALSE";
				}
			}
			else{
				$this->load->view("modals/change_client_status_modal", $data);
			}
		}
	}
	
	public function submittedTickets(){
		if(!$this->auth->isUserLoggedIn()){
			render("login", "default.template");
		}
		else{
			if($this->session->userdata("u_role") != "admin"){
				echo "403 Forbidden";
			}
			else{
				$this->load->module("support");
				$userId = $this->uri->segment(3);
				$username = $this->uri->segment(4);
				
				$data['active']['menu'] = "Clients";
				$data['active']['sub_menu'] = "<a href='" . base_url() . "client/clients'>Clients</a>";
				$data['active']['sub_menu_breadcrumb'] = " > <a href='" . base_url() . "client/clientDetails/" . $userId . "/" . $username . "'> " . $username . "</a> > Ticket History";
				$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
				$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
				$data['submittedTickets'] = $this->support_model->submittedTickets($userId);
				render("support/submitted_tickets.page", "user.template", $data);
			}
		}
	}
	
}
?>