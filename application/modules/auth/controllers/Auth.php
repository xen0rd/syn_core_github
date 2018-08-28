<?php
/**
 * 
 * @author Dean Manalo
 * @version Auth 1.0.1
 *
 */
class Auth extends MX_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model('auth_model');
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

	}
	
	public function login(){
		if($this->input->post(NULL, TRUE)){
			$username = $this->input->post('username', TRUE);
			$password = $this->input->post('password', TRUE);
			$userInfo = $this->auth_model->userInfo($username);
			
			//Checks if the username exists in user table
			if($userInfo === false){
				$this->session->set_flashdata('error_message', 'Invalid credentials');
				redirect($this->uri->segment(3));
			}
			else{
				
				//Checks if the user logged in using the user page
				if($this->uri->segment(3) == "admin" && $userInfo->role_name != "client" && $userInfo->is_active == 1){
					if($this->bcrypt->check_password($password, $userInfo->password)){
						$this->auth_model->updateLastClientIP($username, $_SERVER['REMOTE_ADDR']);
						$this->session->set_flashdata('success_message', 'Login successful');

						$this->session->set_userdata('u_id', $userInfo->id);
						$this->session->set_userdata('u_username', $userInfo->username);
						$this->session->set_userdata('u_first_name', $userInfo->first_name);
						$this->session->set_userdata('u_last_name', $userInfo->last_name);
						$this->session->set_userdata('u_role', $userInfo->role_name);
						$this->session->set_userdata("user", TRUE);
						
						
						//validate license
						$this->load->module('updater');
						$encryptedData = $this->updater_model->accountInfo();
						$decryptedData = $this->encryption->decrypt($encryptedData);
						$dataPart = explode("~", $decryptedData);
						$user = $dataPart[0];
						$licenseKey = $dataPart[1];
							
						$validateLicenseURL = "http://slsv1.grizzlysts.com:8080/validatelicense?licensekey=" . $licenseKey . "&url=" . base_url() ."&version=" . _SYNTHIA_VERSION;
						
						$init = curl_init();
						curl_setopt($init, CURLOPT_URL, $validateLicenseURL);
						curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
						//curl_exec($init);
						if(curl_errno($init) != 0){
							log_message('error', curl_error($init));
						}
						curl_close($init);
						
						
						
						redirect("admin/users");
					}
					else{
						$this->session->set_flashdata('error_message', 'Invalid credentials');
						redirect("admin");
					}
				}
				
				//Checks if the client logged in using the client page
				else if($this->uri->segment(3) != "admin" && $userInfo->role_name == "client" && $userInfo->is_active == 1){
					if($this->bcrypt->check_password($password, $userInfo->password)){
						$this->auth_model->updateLastClientIP($username, $_SERVER['REMOTE_ADDR']);
						$this->session->set_flashdata('success_message', 'Login successful');

						$this->session->set_userdata('c_id', $userInfo->id);
						$this->session->set_userdata('c_username', $userInfo->username);
						$this->session->set_userdata('c_first_name', $userInfo->first_name);
						$this->session->set_userdata('c_last_name', $userInfo->last_name);
						$this->session->set_userdata('c_role', $userInfo->role_name);
						$this->session->set_userdata('c_email', $userInfo->email);
						$this->session->set_userdata("client", TRUE);
                                                
                                                $this->session->unset_userdata('guest_email');
                                                
						redirect(base_url());
					}
					else{
						$this->session->set_flashdata('error_message', 'Invalid credentials');
						redirect("/");
					}
				}
				
				else{
					$this->session->set_flashdata('error_message', 'User is not active.');
					redirect($this->uri->segment(3));
				}
			}
		}
		else{
			echo "ERROR 403 FORBIDDEN";
		}
	}
	
	public function logout(){
		$this->session->set_flashdata('success_message', 'Successfully logged out');
		if($this->uri->segment(3) == "client"){
			$this->session->unset_userdata('c_id');
                        $this->session->unset_userdata('c_username');
                        $this->session->unset_userdata('c_first_name');
                        $this->session->unset_userdata('c_last_name');
                        $this->session->unset_userdata('c_role');
                        $this->session->unset_userdata('c_email');
                        $this->session->unset_userdata("client");
			redirect("client");
		}
		else{
			$this->session->unset_userdata('u_id');
                        $this->session->unset_userdata('u_username');
                        $this->session->unset_userdata('u_first_name');
                        $this->session->unset_userdata('u_last_name');
                        $this->session->unset_userdata('u_role');
                        $this->session->unset_userdata("user");
			redirect("admin");
		}
		
	}
	
	public function modulePermission(){
		
	}
	
	/**
	 * Returns TRUE if a client is logged in, otherwise FALSE
	 * @return boolean
	 */
	public function isClientLoggedIn(): bool{
		return $this->session->userdata('client') == TRUE ? TRUE : FALSE;
	}
	
	
	/**
	 * Returns TRUE if a user is logged in, otherwise FALSE
	 * @return boolean
	 */
	public function isUserLoggedIn(): bool{
		return $this->session->userdata('user') == TRUE ? TRUE : FALSE;
	}
	
	/**
	 * Generates link for email change
	 * @param string $username
	 * @return string
	 */
	public function generateEmailKey($username): string{
		$random = random_string("alnum", 10);
		$code = $random . "~" . $username;
		$this->auth_model->updateEmailKey($username, $random);
		return $this->encryption->encrypt($code);
	}
	
	
	/**
	 * Generates link for password change
	 * @param string $username
	 * @return string
	 */
	public function generatePasswordKey($username): string{
		$random = random_string("alnum", 10);
		$code = $random . "~" . $username;
		$this->auth_model->updatePasswordKey($username, $random);
		return $this->encryption->encrypt($code);
	}
	
	
	public function decryptKey($encryptedParameter){
		$linkParameter = $this->encryption->decrypt($encryptedParameter);
		$linkParts = explode("~", $linkParameter);
		$key = $linkParts[0];
		$username =  $linkParts[1];
		$obj = array("KEY" => $key,
					"USERNAME" => $username
		);
		
		return json_encode($obj);
	}
	
	public function sendEmailVerification(string $username): bool{
		$linkParameter = $this->generateEmailKey($username);
		$email = $this->auth_model->userInfo($username)->new_email;
 		$subject = "Email Verification";
		$msg = "Click this link to verify your account: " . base_url() . "verify/" . rawurlencode(base64_encode($linkParameter));
		
		$this->load->module('user');
		$configHost = $this->user_model->SMTPConfig()->smtp_host;
		$configUser = $this->user_model->SMTPConfig()->smtp_user;
		$decryptedConfigPass = $this->encryption->decrypt($this->user_model->SMTPConfig()->smtp_pass);
		$configPass = $decryptedConfigPass;
		$configPort = $this->user_model->SMTPConfig()->smtp_port;
		
	   $config = array(
		  'protocol' => 'smtp',
		  'smtp_host' => _SMTP_PROTOCOL ."://" . $configHost,
		  'smtp_port' => _SMTP_PORT,
		  'smtp_user' => $configUser,
		  'smtp_pass' => $configPass
		);
		
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		$this->email->from($configUser, 'SYNTHIA - NOREPLY');
		$this->email->to($email);

		$this->email->subject($subject);
		$this->email->message($msg);	
		
		if(!$this->email->send()){
			log_message('error', $this->email->print_debugger());
			return false;
		}
		
		return true;
		
		
	}
	
	public function verifyNewEmail(){
		$encryptedLinkParameter = base64_decode(rawurldecode($this->uri->segment(2)));
		$obj = json_decode($this->decryptKey($encryptedLinkParameter));
		if($this->auth_model->updateEmail($obj->USERNAME, $obj->KEY)){
			$this->session->set_flashdata('success_message', 'Your account has been verified');
			redirect('client');
		}
		else{
			$this->session->set_flashdata('error_message', 'Account verification failed');
			redirect('client');
		}
	}	
	
	public function sendPasswordReset(string $username): bool{
		$linkParameter = $this->generatePasswordKey($username);
		$email = $this->auth_model->userInfo($username)->email;
 		$subject = "Password Reset Request";
		$msg = "Click this link to reset your password: " . base_url() . "reset_password/" . rawurlencode(base64_encode($linkParameter));
		
	  	$this->load->module('user');
		$configHost = $this->user_model->SMTPConfig()->smtp_host;
		$configUser = $this->user_model->SMTPConfig()->smtp_user;
		$decryptedConfigPass = $this->encryption->decrypt($this->user_model->SMTPConfig()->smtp_pass);
		$configPass = $decryptedConfigPass;
		$configPort = $this->user_model->SMTPConfig()->smtp_port;
		
	   $config = array(
		  'protocol' => 'smtp',
		  'smtp_host' => _SMTP_PROTOCOL ."://" . $configHost,
		  'smtp_port' => _SMTP_PORT,
		  'smtp_user' => $configUser,
		  'smtp_pass' => $configPass
		);
		
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		$this->email->from($configUser, 'SYNTHIA - NOREPLY');
		$this->email->to($email);

		$this->email->subject($subject);
		$this->email->message($msg);	
		
		if(!$this->email->send()){
			log_message('error', $this->email->print_debugger());
			return false;
		}
		
		return true;
		
		
	}
	
	public function resetPassword(){
		$encryptedLinkParameter = base64_decode(rawurldecode($this->uri->segment(2)));
		$obj = json_decode($this->decryptKey($encryptedLinkParameter));
		
		if($this->input->post(NULL, TRUE)){
			if($this->form_validation->run('reset_password')){
				$newPassword = $this->input->post('new_password', TRUE);
				$hashedPassword = $this->bcrypt->hash_password($newPassword);
				if($this->auth_model->updatePassword($obj->USERNAME, $hashedPassword)){
					$this->session->set_flashdata('success_message', 'Password has been successfully changed');
					redirect('client');
				}
				else{
					$this->session->set_flashdata('error_message', 'Failed to update your password');
					redirect('client');
				}
			}
			else{
				render("reset_password.form", "default.template");
			}
		}
		else{
			if($this->auth_model->passwordKey($obj->USERNAME)->new_password_key === $obj->KEY){
				render("reset_password.form", "default.template");
			}
			else{
				$this->session->set_flashdata('error_message', 'The request is already expired');
				redirect('client');
			}
		}
	}	
	
	public function securityQuestion(){
		if($this->input->post(NULL, TRUE)){
			$username = $this->input->post('username', TRUE);
			if($this->form_validation->run('security_question')){
				if($this->sendPasswordReset($username)){
					$this->session->set_flashdata("success_message", "An email has been sent to your email address. Please follow the instructions to reset your password");
					redirect("client");
				}
				else{
					$this->session->set_flashdata("error_message", "Failed to send password reset email");
					redirect("client");
				}
			}
			else{
				$data['username'] = $username;
				$data['security_question'] = $this->auth_model->userInfo($username)->security_question;
				render("security_question.form", "default.template", $data);
			}
		}
		else{
			echo "ERROR 403 FORBIDDEN";
		}
	}
	
	
	public function isSecurityAnswerCorrect(string $answer): bool{
		$username = $this->input->post('username', TRUE);
		$storedSecurityAnswer = $this->auth_model->securityAnswer($username)->security_answer;
		$decyptedSecurityAnswer = $this->encryption->decrypt($storedSecurityAnswer);
		if($decyptedSecurityAnswer === $answer){
			return true;
		}
		else{
			$this->form_validation->set_message("isSecurityAnswerCorrect", "The provided answer is incorrect");
			return false;
		}
	}
	

	/**
	 * Form Validation Callback
	 * Checks whether the given username was already taken
	 * @param string $username
	 * @return boolean
	 */
	public function isAvailable(string $username): bool{
		if($this->auth_model->userInfo($username) === false){
			return true;
		}
		else{
			$this->form_validation->set_message("isAvailable", "Username was already taken");
			return false;
		}
	}
	
	
	/**
	 * Form Validation Callback
	 * Checks whether the given email address was already taken
	 * @param string $email
	 * @return boolean
	 */
	public function isEmailExists(string $email): bool{
		if($this->auth_model->userInfoEmail($email) === false){
			return true;
		}
		else{
			$this->form_validation->set_message("isEmailExists", "Email address was already taken");
			return false;
		}
	}
	
	/**
	 * Form Validation Callback
	 * Checks whether the given username exists
	 * @param string $username
	 * @return boolean
	 */
	public function isUsernameExists(string $username): bool{
		if($this->auth_model->userInfo($username) !== false){
			return true;
		}
		else{
			$this->form_validation->set_message("isUsernameExists", "Invalid username");
			return false;
		}
	}
	

	/**
	 * Form Validation Callback
	 * Checks if the entered old password of the client matches the current stored password
	 * @param string $oldPassword
	 * @return bool
	 */
	public function isClientPasswordMatch(string $oldPassword): bool{
		$username = $this->session->userdata('c_username');
		$userInfo = $this->auth_model->userInfo($username);
		if($this->bcrypt->check_password($oldPassword, $userInfo->password)){
			return true;
		}
		else{
			$this->form_validation->set_message("isClientPasswordMatch", "Incorrect old password");
			return false;
		}
	}
	
	/**
	 * Form Validation Callback
	 * Checks if the entered old password of the user matches the current stored password
	 * @param string $oldPassword
	 * @return bool
	 */
	public function isUserPasswordMatch(string $oldPassword): bool{
		$username = $this->session->userdata('u_username');
		$userInfo = $this->auth_model->userInfo($username);
		if($this->bcrypt->check_password($oldPassword, $userInfo->password)){
			return true;
		}
		else{
			$this->form_validation->set_message("isUserPasswordMatch", "Incorrect old password");
			return false;
		}
	}

}
?>