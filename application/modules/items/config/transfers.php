<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['transfers/edit'] = $config['transfers/add'] = array (
        array(
            'field' => 'branch_id_from',
            'label' => 'Branch from',
            'rules' => 'trim|required'
        ),        
        array(
            'field' => 'branch_id_to',
            'label' => 'required',
            'rules' => 'trim|required'
        ),    
        array(
            'field' => 'items[]',
            'label' => 'Items',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'qty[]',
            'label' => 'Quantity',
            'rules' => 'trim|required'
        ),        
        array(
            'field' => 'code',
            'label' => 'Control Number',
            'rules' => 'trim|required'
        )        
);
