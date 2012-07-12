<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['branch/edit'] = $config['branch/add'] = array (
        array(
            'field' => 'name',
            'label' => 'Branch Name',
            'rules' => 'trim|required'
        ),        
        array(
            'field' => 'location',
            'label' => 'Branch Location',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'branch_code',
            'label' => 'Branch Code',
            'rules' => 'trim|required'
        )        
);
