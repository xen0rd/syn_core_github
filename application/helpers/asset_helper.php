<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Returns path of images folder
 * @return string
 */
function images_url(){
	return base_url()."_assets/main/images/";
}

/**
 * Returns path of css folder
 * @return string
 */
function css_url(){
	return base_url()."_assets/main/css/";
}

/**
 * Returns path of js folder
 * @return string
 */
function js_url(){
	return base_url()."_assets/main/js/";
}

/**
 * Returns path of fonts folder
 * @return string
 */
function fonts_url(){
	return base_url()."_assets/main/fonts/";
}

/**
 * Returns path of uploaded images
 * @return string
 */
function uploaded_images_url(){
	return base_url()."uploads/";
}



?>
