<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * @param string $page
 * @param string $template
 * @param object data (optional)
 * @return string
 */
function render($page, $template, $data = null){
	$CI =& get_instance();
	$data['content'] = $CI->load->view($page . '.php', $data, true);
	return $CI->load->view('templates/' . $template . '.php', $data);
}

function title(){
	$CI =& get_instance();
	$CI->load->model("user_model");
	return $CI->user_model->title()->app_name;	 
}

function logo(){
	$CI =& get_instance();
	$CI->load->model("user_model");
	return $CI->user_model->logo()->logo;	 
}

function miniLogo(){
	$CI =& get_instance();
	$CI->load->model("user_model");
	return $CI->user_model->miniLogo()->mini_logo;	 
}



?>
