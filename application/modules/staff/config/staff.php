<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['user/edit'] = $config['user/add'] = array (
        array(
            'field' => 'firstname',
            'label' => 'First Name',
            'rules' => 'trim|required'
        ),        
        array(
            'field' => 'lastname',
            'label' => 'Branch Location',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required'
        ),        
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|min_length[6]'
        ),
        array(
            'field' => 'branch_id',
            'label' => 'Branch',
            'rules' => 'trim|required'
        ),    
);
