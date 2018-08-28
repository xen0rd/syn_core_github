<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config = array(  
			'create_ticket' => array(
									array(
                                            'field' => 'subject',
                                            'label' => 'subject',
                                            'rules' => 'trim|required'
                                         ),
									array(
                                            'field' => 'description',
                                            'label' => 'description',
                                            'rules' => 'trim|required'
                                         )
								)
);
?>