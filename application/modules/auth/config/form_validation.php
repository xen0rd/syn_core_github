<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$config = array(
    'add_client' => array(
        array(
            'field' => 'username',
            'label' => 'username',
            'rules' => 'trim|required|alpha_numeric|min_length[4]|max_length[20]|callback_isAvailable'
        ),
        array(
            'field' => 'password',
            'label' => 'password',
            'rules' => 'trim|required|min_length[8]|max_length[20]'
        ),
        array(
            'field' => 'confirm_password',
            'label' => 'confirm password',
            'rules' => 'trim|required|matches[password]'
        ),
        array(
            'field' => 'security_question_id',
            'label' => 'security question',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'security_answer',
            'label' => 'security answer',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'first_name',
            'label' => 'first name',
            'rules' => 'trim|required|max_length[45]'
        ),
        array(
            'field' => 'last_name',
            'label' => 'last name',
            'rules' => 'trim|required|max_length[45]'
        ),
        array(
            'field' => 'new_email',
            'label' => 'email',
            'rules' => 'trim|required|valid_email|callback_isEmailExists'
        ),
        array(
            'field' => 'phone',
            'label' => 'phone',
            'rules' => 'trim'
        ),
        array(
            'field' => 'current_address',
            'label' => 'current address',
            'rules' => 'trim'
        ),
        array(
            'field' => 'permanent_address',
            'label' => 'permanent address',
            'rules' => 'trim'
        ),
        array(
            'field' => 'state',
            'label' => 'state',
            'rules' => 'trim|alpha'
        ),
        array(
            'field' => 'postal_code',
            'label' => 'postal code',
            'rules' => 'trim|alpha_numeric'
        ),
        array(
            'field' => 'country_code',
            'label' => 'country',
            'rules' => 'trim'
        ),
        array(
            'field' => 'date_of_birth',
            'label' => 'date of birth',
            'rules' => 'trim|required'
        )
    ),
    'add_user' => array(
        array(
            'field' => 'username',
            'label' => 'username',
            'rules' => 'trim|required|alpha_numeric|min_length[4]|max_length[20]|callback_isAvailable'
        ),
        array(
            'field' => 'password',
            'label' => 'password',
            'rules' => 'trim|required|min_length[8]|max_length[20]'
        ),
        array(
            'field' => 'confirm_password',
            'label' => 'confirm password',
            'rules' => 'trim|required|matches[password]'
        ),
        array(
            'field' => 'security_question_id',
            'label' => 'security question',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'security_answer',
            'label' => 'security answer',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'first_name',
            'label' => 'first name',
            'rules' => 'trim|required|max_length[45]'
        ),
        array(
            'field' => 'last_name',
            'label' => 'last name',
            'rules' => 'trim|required|max_length[45]'
        ),
        array(
            'field' => 'new_email',
            'label' => 'email',
            'rules' => 'trim|required|valid_email|callback_isEmailExists'
        ),
        array(
            'field' => 'phone',
            'label' => 'phone',
            'rules' => 'trim'
        ),
        array(
            'field' => 'current_address',
            'label' => 'current address',
            'rules' => 'trim'
        ),
        array(
            'field' => 'permanent_address',
            'label' => 'permanent address',
            'rules' => 'trim'
        ),
        array(
            'field' => 'country_code',
            'label' => 'country',
            'rules' => 'trim'
        ),
        array(
            'field' => 'date_of_birth',
            'label' => 'date of birth',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'role_id',
            'label' => 'role',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'department_id',
            'label' => 'department',
            'rules' => 'trim|required'
        )
    ),
    'change_client_password' => array(
        array(
            'field' => 'old_password',
            'label' => 'old password',
            'rules' => 'trim|required|callback_isClientPasswordMatch'
        ),
        array(
            'field' => 'new_password',
            'label' => 'new password',
            'rules' => 'trim|required|min_length[8]|max_length[20]'
        ),
        array(
            'field' => 'confirm_new_password',
            'label' => 'confirm new password',
            'rules' => 'trim|required|matches[new_password]'
        )
    ),
    'admin_change_client_password' => array(
        array(
            'field' => 'new_password',
            'label' => 'new password',
            'rules' => 'trim|required|min_length[8]|max_length[20]'
        ),
        array(
            'field' => 'confirm_new_password',
            'label' => 'confirm new password',
            'rules' => 'trim|required|matches[new_password]'
        )
    ),
    'change_user_password' => array(
        array(
            'field' => 'old_password',
            'label' => 'old password',
            'rules' => 'trim|required|callback_isUserPasswordMatch'
        ),
        array(
            'field' => 'new_password',
            'label' => 'new password',
            'rules' => 'trim|required|min_length[8]|max_length[20]'
        ),
        array(
            'field' => 'confirm_new_password',
            'label' => 'confirm new password',
            'rules' => 'trim|required|matches[new_password]'
        )
    ),
    'profile_settings' => array(
        array(
            'field' => 'phone',
            'label' => 'phone',
            'rules' => 'trim'
        ),
        array(
            'field' => 'current_address',
            'label' => 'current address',
            'rules' => 'trim'
        ),
        array(
            'field' => 'permanent_address',
            'label' => 'permanent address',
            'rules' => 'trim'
        ),
        array(
            'field' => 'state',
            'label' => 'state',
            'rules' => 'trim|alpha'
        ),
        array(
            'field' => 'postal_code',
            'label' => 'postal code',
            'rules' => 'trim|alpha_numeric'
        ),
        array(
            'field' => 'country_code',
            'label' => 'country',
            'rules' => 'trim'
        )
    ),
    'account_settings' => array(
        array(
            'field' => 'new_email',
            'label' => 'email',
            'rules' => 'trim|required|valid_email|callback_isEmailExists'
        ),
        array(
            'field' => 'security_question_id',
            'label' => 'security question',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'security_answer',
            'label' => 'security answer',
            'rules' => 'trim|required'
        )
    ),
    'forgot_password' => array(
        array(
            'field' => 'username',
            'label' => 'username',
            'rules' => 'trim|required|callback_isUsernameExists'
        )
    ),
    'security_question' => array(
        array(
            'field' => 'security_answer',
            'label' => 'security answer',
            'rules' => 'trim|required|callback_isSecurityAnswerCorrect'
        ),
        array(
            'field' => 'username',
            'label' => 'username',
            'rules' => 'trim|required'
        )
    ),
    'reset_password' => array(
        array(
            'field' => 'new_password',
            'label' => 'new password',
            'rules' => 'trim|required|min_length[8]|max_length[20]'
        ),
        array(
            'field' => 'confirm_new_password',
            'label' => 'confirm new password',
            'rules' => 'trim|required|matches[new_password]'
        )
    ),
    'smtp_config' => array(
        array(
            'field' => 'smtp_host',
            'label' => 'smtp host',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'smtp_user',
            'label' => 'smtp user',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'smtp_pass',
            'label' => 'smtp pass',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'imap_host',
            'label' => 'imap host',
            'rules' => 'trim|required'
        ),
    ),
    'payment_methods' => array(
        array(
            'field' => 'business_email',
            'label' => 'business email',
            'rules' => 'trim|required|valid_email'
        ),
        array(
            'field' => 'identity_token',
            'label' => 'identity token',
            'rules' => 'trim|required'
        )
    )
);
?>