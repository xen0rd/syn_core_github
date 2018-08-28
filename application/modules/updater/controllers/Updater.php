<?php
/**
 *
 * @author Dean Manalo
 * @version Updater 2.0.0
 *
 */
class Updater extends MX_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->module('auth');
		$this->load->model('updater_model');
		$this->load->library('unzip');
		
		if(!$this->auth->isUserLoggedIn()){
			redirect("admin");
		}
		
		if(!is_dir("backup")){
			$mask = umask(0);
			mkdir("backup", 0775);
			umask($mask);
		}
		if(!is_dir("tmp")){
			$mask = umask(0);
			mkdir("tmp", 0775);
			umask($mask);
		}
	}
	
	public function check(){
		if($this->auth->isUserLoggedIn()){
			$encryptedData = $this->updater_model->accountInfo();
			$decryptedData = $this->encryption->decrypt($encryptedData);
			$dataPart = explode("~", $decryptedData);
			$user = $dataPart[0];
			$licenseKey = $dataPart[1];
			
			//get latest version
			$getVersionURL = "http://slsv1.grizzlysts.com:8080/getlatestversion?licensekey=" . $licenseKey . "&url=" . base_url() ."&version=" . _SYNTHIA_VERSION;
			
			$init = curl_init();
			curl_setopt($init, CURLOPT_URL, $getVersionURL);
			curl_setopt($init, CURLOPT_HTTPHEADER, array('Synthia-Version: ' . _SYNTHIA_VERSION));
			curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
	
			//echo curl_exec($init) == "false" ? 0 : 1;
			echo 1;
			
			if(curl_errno($init) != 0){
				log_message('error', curl_error($init));
			}
			
			curl_close($init);
		}
	}
		
	public function download(){
		if($this->auth->isUserLoggedIn()){
			$encryptedData = $this->updater_model->accountInfo();
			$decryptedData = $this->encryption->decrypt($encryptedData);
			$dataPart = explode("~", $decryptedData);
			$user = $dataPart[0];
			$licenseKey = $dataPart[1];
			$url = "slsv1.grizzlysts.com:8080/getupgradefile?licensekey=" . $licenseKey . "&url=" . base_url() ."&version=" . _SYNTHIA_VERSION;
			$destination = "tmp/update.zip";
			$file = fopen($destination, "w+");
			
			$init = curl_init();
			curl_setopt($init, CURLOPT_URL, $url);
			curl_setopt($init, CURLOPT_HTTPHEADER, array('Synthia-Version: ' . _SYNTHIA_VERSION));
			curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($init, CURLOPT_HEADERFUNCTION, array($this, "headerCallback"));
			//curl_setopt($init, CURLOPT_HEADER, true);
			curl_setopt($init, CURLOPT_FILE, $file);
			curl_setopt($init, CURLOPT_PROGRESSFUNCTION, array($this, "progressCallback"));
			curl_setopt($init, CURLOPT_NOPROGRESS, false);
			curl_exec($init);
			if(curl_errno($init) != 0){
				log_message('error', curl_error($init));
			}
			curl_close($init);
			fclose($file);
		}
	}
	
	public function install(){
		if($this->auth->isUserLoggedIn()){
			$status = $this->unzip->extract('tmp/update.zip', './');
			if($status){
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Synthia has been <i>updated</i> to version <b>' . _SYNTHIA_VERSION . '</b>', 1, _UPDATER);
				echo 1;
			}
			else{
				$this->synthia->audit_trail((int)$this->session->userdata('u_id'), 'Failed to <i>update</i> Synthia', 0, _UPDATER);
				log_message("error", $this->unzip->error_string() . " - Error extracting files - error occurred at " . __DIR__ . " - Updater{install()}");
				echo 0;
			}
		}
	}
	
	public function appBackup(){
		if($this->auth->isUserLoggedIn()){
			if($this->recursiveCopy('application', 'backup/app-' . date('mdYHis'))){
				echo 1;
			}else{
				log_message("error", "Error backing up files - error occurred at " . __DIR__ . " - Updater{appBackup()}");
				echo 0;
			}
		}
	}
	
	protected function headerCallback($resource, $header){
		if(strpos($header, "Synthia-Version") !== FALSE){
			$fo = fopen('tmp/update_version', 'w');
			fwrite($fo, trim(explode(":",$header)[1]));
			fclose($fo);
		}
		return strlen($header);
	}
	
	protected function progressCallback($resource, $downloadSize, $downloaded){		
		if($downloadSize > 0){
			$progress = round($downloaded * 100 / $downloadSize);
		}
		else{
			$progress = 0;
		}
		$fo = fopen('tmp/update_progress', 'w');
		fwrite($fo, $progress);
		fclose($fo);
	}
	
	protected function recursiveCopy($src, $dst): bool{
		if(file_exists($dst)){
			rmdir($dst);
		}
		if(is_dir($src)){
			$mask = umask(0);
			mkdir($dst, 0775);
			umask($mask);
			$files = scandir($src);
			foreach($files as $file)
			if($file != "." && $file != "..")
			$this->recursiveCopy("$src/$file", "$dst/$file");
		}
		else if(file_exists($src)){
			copy($src,$dst);
		}
		
		return true;
	}
	
	public function removeTMP($dir = "./tmp") {
		if($this->auth->isUserLoggedIn()){
			if (is_dir($dir)) {
				$objects = scandir($dir);
				foreach ($objects as $object) {
					if ($object != "." && $object != "..") {
						if (is_dir($dir."/".$object))
							removeTMP($dir."/".$object);
							else
								unlink($dir."/".$object);
					}
				}
				rmdir($dir);
			}
			$this->session->set_flashdata("success_message","Updates has been successfully installed.");
		}
	}
	
}
	