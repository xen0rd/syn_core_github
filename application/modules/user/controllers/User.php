<?php
/**
 *
 * @author Dean Manalo
 * @version User 1.0.3
 *
 */
class User extends MX_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->module('auth');
		$this->load->model('user_model');
		
	}
	
	public function index(){
		if(!$this->auth->isUserLoggedIn()){
			render("login", "default.template");
		}
		else{
			$data['active']['menu'] = "Dashboard";
			$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
			render("dashboard.page", "user.template", $data);
			$this->loadUpdaterModal();
		}
	}
	
	public function users(){
		if(!$this->auth->isUserLoggedIn()){
			render("login", "default.template");
		}
		else{
			if($this->session->userdata("u_role") != "admin"){
				echo "403 Forbidden";
			}
			else{
				$data['active']['menu'] = "Users";
				$data['active']['sub_menu'] = "Users";
				$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
				$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
				render("users_list.page", "user.template", $data);
			}
		}
	}
	
	public function getUsers(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			if($this->session->userdata("u_role") != "admin"){
				echo "403 Forbidden";
			}
			else{
				echo json_encode(array("data" => $this->user_model->usersInfo()));
			}
		}
	}
	
	public function userDetails(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			if($this->session->userdata("u_role") != "admin"){
				echo "403 Forbidden";
			}
			else{
				$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
				$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
				$userId = $this->uri->segment(3);
				$username = $this->uri->segment(4);
				
				$data['userDetails'] = $this->auth_model->userInfo($username);
					
				$data['active']['menu'] = "Users";
				$data['active']['sub_menu'] = "<a href='" . base_url() . "user/users'>Users</a>";
				$data['active']['sub_menu_breadcrumb'] = " > " . $username;
					
				render("user/user_details.page", "user.template", $data);
			}
		}
	}
	
	public function configuration(){
		if(!$this->auth->isUserLoggedIn()){
			render("login", "default.template");
		}
		else{
			if($this->session->userdata("u_role") != "admin"){
				echo "403 Forbidden";
			}
			else{
				$data['active']['menu'] = "Configuration";
				$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
				$page = null;
			
				if($this->uri->segment(3) === "smtp"){
					$page = "smtp_configuration.page";
					
					if($this->input->post(NULL, TRUE)){
						if($this->form_validation->run('smtp_config')){
							$encryptedPassword = $this->encryption->encrypt($this->input->post('smtp_pass', TRUE));
							$SMTPHost = $this->input->post('smtp_host', TRUE);
							$user = $this->input->post('smtp_user', TRUE);
							$pass = $encryptedPassword;
							$IMAPHost = $this->input->post('imap_host', TRUE);
							
							if($this->user_model->SMTPConfig()->smtp_pass == $this->input->post('smtp_pass', TRUE)){
								if($this->user_model->updateSMTPConfig($SMTPHost, $user, $this->input->post('smtp_pass', TRUE), $IMAPHost)){
									$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Email configuration has been <i>updated</i>', 1, _USER);
									$this->session->set_flashdata('success_message', 'Email configuration updated');
									redirect(current_url());
								}
								else{
									$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> Email configuration', 0, _USER);
									$this->session->set_flashdata('error_message', 'Failed to update Email configuration');
									redirect(current_url());
								}	
							}
							else{
								if($this->user_model->updateSMTPConfig($SMTPHost, $user, $pass, $IMAPHost)){
									$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Email configuration has been <i>updated</i>', 1, _USER);
									$this->session->set_flashdata('success_message', 'Email configuration updated');
									redirect(current_url());
								}
								else{
									$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> Email configuration', 0, _USER);
									$this->session->set_flashdata('error_message', 'Failed to update Email configuration');
									redirect(current_url());
								}
							}
							
							if($this->user_model->updateSMTPConfig($SMTPHost, $user, $pass, $IMAPHost)){
								$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Email configuration has been <i>updated</i>', 1, _USER);
								$this->session->set_flashdata('success_message', 'Email configuration updated');
								redirect(current_url());
							}
							else{
								$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> Email configuration', 0, _USER);
								$this->session->set_flashdata('error_message', 'Failed to update Email configuration');
								redirect(current_url());
							}
						}
						else{
							$data['smtp'] = $this->user_model->SMTPConfig();
							$data['active']['sub_menu'] = "Email Settings";
							$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
						}
					}
					else{
						$data['smtp'] = $this->user_model->SMTPConfig();
						$data['active']['sub_menu'] = "Email Settings";
						$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
					}
				}
				else if($this->uri->segment(3) === "settings"){
					$page = "settings.page";
					$data['active']['sub_menu'] = "Application Settings";
					$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
					
					if($this->input->post(NULL, TRUE)){
						$fileName = date('mdY') . time();
						$config['file_name'] = $fileName;
						$config['upload_path'] = './uploads/';
						$config['allowed_types'] = 'gif|jpg|png';
						$config['max_size'] = 1024;
						$config['max_width'] = 0;
						$config['max_height'] = 0;
						
						/*Upload for regular logo*/
						if($this->uri->segment(4) == "reg"){
							$fileExtension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
							$_POST['logo'] = $fileName . "." . $fileExtension;
							
							$this->load->library('upload', $config);
							
							if(!$this->upload->do_upload('logo')){
								$error = array('error' => $this->upload->display_errors());
								log_message('error', $error);
								$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>upload</i> logo', 0, _USER);
								$this->session->set_flashdata("error_message", "Image upload failed. Make sure that the attached file meet the requirements and try again.");
								render("user.page", "user.template", $data);
							}
							else{
								if($this->user_model->updateLogo($this->input->post("logo", TRUE))){
									$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Logo has been updated', 1, _USER);
									$this->session->set_flashdata("success_message", "Logo has been successfully updated");
									redirect(current_url());
								}
								else{
									$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Logo upload successful but failed to <i>update</i> database', 0, _USER);
									$this->session->set_flashdata("error_message", "Logo update failed. Please try again.");
									render("user.page", "user.template", $data);
								}
							}
						}
						
						/*Upload for mini logo*/
						if($this->uri->segment(4) == "mini"){
							$fileExtension = pathinfo($_FILES['mini_logo']['name'], PATHINFO_EXTENSION);
							$_POST['mini_logo'] = $fileName . "." . $fileExtension;
						
							$this->load->library('upload', $config);
						
							if(!$this->upload->do_upload('mini_logo')){
								$error = array('error' => $this->upload->display_errors());
								log_message('error', $error);
								$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>upload</i> mini logo', 0, _USER);
								$this->session->set_flashdata("error_message", "Image upload failed. Make sure that the attached file meet the requirements and try again.");
								render("user.page", "user.template", $data);
							}
							else{
								if($this->user_model->updateMiniLogo($this->input->post("mini_logo", TRUE))){
									$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Mini logo has been updated', 1, _USER);
									$this->session->set_flashdata("success_message", "Mini logo has been successfully updated");
									redirect(current_url());
								}
								else{
									$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Mini logo upload successful but failed to <i>update</i> database', 0, _USER);
									$this->session->set_flashdata("error_message", "Mini logo update failed. Please try again.");
									render("user.page", "user.template", $data);
								}
							}
						}
						
					}	
				}
				else if($this->uri->segment(3) === "payment_methods"){
					$page = "payment_methods.page";
					
					if($this->input->post(NULL, TRUE)){
						if($this->form_validation->run('payment_methods')){
							$businessEmail = $this->input->post('business_email', TRUE);
							$identityToken = $this->input->post('identity_token', TRUE);
                                                        if($this->user_model->addPaymentMethod($businessEmail, $identityToken)){
								$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Payment method has been <i>updated</i>', 1, _USER);
								$this->session->set_flashdata('success_message', 'Business email updated');
								redirect(current_url());
                                                        }
                                                        else{
                                                                $this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> Payment method ', 0, _USER);
                                                                $this->session->set_flashdata('error_message', 'Failed to update Payment method');
                                                                redirect(current_url());
                                                        }
						}
						else{
							$data['payment_method'] = $this->user_model->paymentMethod();
							$data['active']['sub_menu'] = "Payment Methods";
							$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
						}
					}
					else{
						$data['payment_method'] = $this->user_model->paymentMethod();
						$data['active']['sub_menu'] = "Payment Methods";
						$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
					}
                                }
				render($page, "user.template", $data);
			}
		}
	}
	
	public function changePassword(){
		if(!$this->auth->isUserLoggedIn()){
			render("login", "default.template");
		}
		else{
			if($this->input->post(NULL, TRUE)){
				if($this->form_validation->run('change_user_password')){
					$username = $this->session->userdata('u_username');
					$newPassword = $this->input->post('new_password');
					$hashedPassword = $this->bcrypt->hash_password($newPassword);
					if($this->auth_model->updatePassword($username, $hashedPassword)){
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Password has been <i>updated</i>', 1, _USER);
						$this->session->set_flashdata('success_message', 'Password change successful');
						redirect(current_url());
					}
					else{
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> password', 0, _USER);
						$this->session->set_flashdata('error_message', 'Failed to update your password');
						redirect(current_url());
					}
				}
				else{
					$data['active']['menu'] = "Change Password";
					
					$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
					$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
					render('user/change_password.form', 'user.template', $data);
				}
			}
			else{
				$data['active']['menu'] = "Change Password";
				
				$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
				$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
				render("user/change_password.form", "user.template", $data);
			}
		}
	}

	public function profileSettings(){
		if(!$this->auth->isUserLoggedIn()){
			render("login", "default.template");
		}
		else{
			$username = $this->session->userdata('u_username');
			
			if($this->input->post(NULL, TRUE)){
				if($this->form_validation->run('profile_settings')){
					unset($_POST['first_name']);
					unset($_POST['last_name']);
					unset($_POST['date_of_birth']);
					if($this->auth_model->updateUserInfo($this->input->post(NULL, TRUE), $username)){
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Profile has been <i>updated</i>', 1, _USER);
						$this->session->set_flashdata('success_message', 'Your profile has been successfully updated');
						redirect(current_url());
					}
					else{
						$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> profile', 0, _USER);
						$this->session->set_flashdata('info_message', 'No changes were made');
						redirect(current_url());
					}
				}
				else{
					$data['active']['menu'] = "Profile Settings";
					
					$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
					$data['userInfo'] = $this->auth_model->userInfo($username);
					render('user/profile_settings.form', 'user.template', $data);
				}
			}
			else{
				$data['active']['menu'] = "Profile Settings";
				
				$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
				$data['userInfo'] = $this->auth_model->userInfo($username);
				render('user/profile_settings.form', 'user.template', $data);
			}
		}
	}
	
	public function accountSettings(){
		if(!$this->auth->isUserLoggedIn()){
			render("login", "default.template");
		}
		else{
			$username = $this->session->userdata('u_username');
			
			if($this->input->post(NULL, TRUE)){
				if($this->form_validation->run('account_settings')){
					unset($_POST['username']);
					$currentEmail = $this->auth_model->userInfo($username)->email;
					 
					if($currentEmail == $this->input->post('new_email', TRUE)){
						unset($_POST['new_email']);
						$_POST['security_answer'] = $this->encryption->encrypt($this->input->post('security_answer', TRUE));
						if($this->auth_model->updateUserInfo($this->input->post(NULL, TRUE), $username)){
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Account details has been <i>updated</i>', 1, _USER);
							$this->session->set_flashdata('success_message', 'Your account details has been updated');
							redirect(current_url());
						}
						else{
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> account details', 0, _USER);
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
								$this->session->set_flashdata('error_message', 'Failed to send email verification code. Please verify that you have a valid configuration to send an email.');
							}
							redirect(current_url());
						}
						else{
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> account details', 0, _USER);
							$this->session->set_flashdata('error_message', 'Failed to update your account details');
							redirect(current_url());
						}
					}
					
				}
				else{
					$data['active']['menu'] = "Account Settings";
					
					$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
					$data['userInfo'] = $this->auth_model->userInfo($username);
					render('user/account_settings.form', 'user.template', $data);
				}
			}
			else{
				$data['active']['menu'] = "Account Settings";
				
				$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
				$data['userInfo'] = $this->auth_model->userInfo($username);
				render('user/account_settings.form', 'user.template', $data);
			}	
		}
	}
	
	public function removePendingEmail(){
		if(!$this->auth->isUserLoggedIn()){
			render("login", "default.template");
		}
		else{
			$username = $this->session->userdata('u_username');
			if($this->auth_model->deleteUserPendingEmail($username)){
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Pending email has been <i>removed</i>', 1, _USER);
				$this->session->set_flashdata('success_message', 'Pending email has been removed');
				redirect("admin/account_settings");
			}else{
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>remove</i> pending email', 0, _USER);
				$this->session->set_flashdata('error_message', 'Failed to remove pending email');
				redirect("admin/account_settings");
			}
		}
	}
	
	public function register(){
		if(!$this->auth->isUserLoggedIn()){
			render("login", "default.template");
		}
		else{
			if($this->session->userdata("u_role") != "admin"){
				echo "403 Forbidden";
			}
			else{
				$this->load->module('department');
				if($this->input->post(NULL, TRUE)){
					if($this->form_validation->run('add_user')){
						unset($_POST['confirm_password']);
						
						$_POST['date_of_birth'] = date_format(new DateTime($this->input->post('date_of_birth')), 'Y-m-d');
						$_POST['password'] = $this->bcrypt->hash_password($this->input->post('password', TRUE));
						$_POST['security_answer'] = $this->encryption->encrypt($this->input->post('security_answer', TRUE));
						if($this->auth_model->addUser($this->input->post(NULL, TRUE))){
							$this->auth->sendEmailVerification($this->input->post('username', TRUE));
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'New user has been <i>registered</i>', 1, _USER);
							$this->session->set_flashdata("success_message", "Registration successful");
							redirect(base_url() . 'admin/users');
						}
						else{
							$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>register</i> new user', 0, _USER);
							$this->session->set_flashdata("error_message", "Failed to register new user");
							redirect(base_url() . 'admin/users');
						}
					}
					else{
						$data['active']['menu'] = "Create New Account";
						
						$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
						$data['roles'] = $this->user_model->roles();
						$data['departments'] = $this->department_model->activeDepartments();
						$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
						render("user/registration.form", "user.template", $data);
					}
				}
				else{
					$data['active']['menu'] = "Create New Account";
					
					$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
					$data['roles'] = $this->user_model->roles();
					$data['departments'] = $this->department_model->activeDepartments();
					$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
					render("user/registration.form", "user.template", $data);
				}
			}
		}
	}
	
	public function changeSkin(){
		if(!$this->auth->isUserLoggedIn()){
			render("login", "default.template");
		}
		else{
			$username = $this->session->userdata('u_username');
			$skin = $this->input->post('skin_id');
			if($this->user_model->updateSkin($username, $skin)){
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'User theme has been<i>updated</i>', 1, _USER);
				$this->session->set_flashdata('success_message', 'Skin successfully changed');
			}
			else{
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> user theme', 0, _USER);
				$this->session->set_flashdata('error_message', 'Failed to update skin');
			}
			
			redirect(base_url() . 'admin/users');
		}
	}
	
	public function loadUpdaterModal(){
		if(!$this->auth->isUserLoggedIn()){
			render("login", "default.template");
		}
		else{
			$this->load->module('updater');
			$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$this->load->view("updater/modals/update_modal.php", $data);
		}
	}
	
	public function changeUserStatus(){
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		else{
			$data['userInfo'] = $this->auth_model->userInfo($this->session->userdata("u_username"));
			$data['sidebar'] = $this->load->view("sidebar/sidebar.php", $data, TRUE);
			if($this->input->post(NULL, TRUE)){
				$userId = $this->input->post("id", TRUE);
				$username = $this->user_model->username($userId);
				$status = $this->user_model->userStatus($userId) == 0 ? 1 : 0;
				if($this->user_model->updateUserStatus($userId, $status)){
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'User <b>' . $username . '</b> has been <i>' . ($status == '1' ? 'enabled' : 'disabled') . '</i>', 1, _USER);
					echo "TRUE";
				}
				else{
					$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to change the <i>status</i> of user <b>' . $username . '</b>', 0, _USER);
					echo "FALSE";
				}
			}
			else{
				$this->load->view("modals/change_user_status_modal", $data);
			}
		}
	}
	
}
?>