<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['inventory/edit'] = $config['inventory/add'] = array (
        array(
            'field' => 'item_id',
            'label' => 'Item',
            'rules' => 'trim|required'
        ),        
        array(
            'field' => 'branch_id',
            'label' => 'Branch',
            'rules' => 'trim|required'
        ),    
        array(
            'field' => 'quantity',
            'label' => 'Quantity',
            'rules' => 'trim|required'
        )
);
