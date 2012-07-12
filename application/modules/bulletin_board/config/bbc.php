<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['validation_bbc_post'] = array (
        array(
            'field' => 'writer',
            'label' => 'Writer',
            'rules' => 'trim|required|xss_clean'
        ),        
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'message',
            'label' => 'Message',
            'rules' => 'trim|required|xss_clean'
        ),
        array(
            'field' => 'field_filename',
            'label' => 'Uploaded file',
            'rules' => 'trim|callback_handle_file_upload|xss_clean'
        ),
);
