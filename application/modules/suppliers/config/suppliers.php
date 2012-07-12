<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['suppliers/edit'] = $config['suppliers/add'] = array (
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),        
        array(
            'field' => 'address',
            'label' => 'Address',
            'rules' => 'trim'
        ),
        array(
            'field' => 'contact',
            'label' => 'Contact',
            'rules' => 'trim'
        )
);
