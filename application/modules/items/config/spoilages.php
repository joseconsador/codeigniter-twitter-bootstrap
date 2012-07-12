<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['spoilages/edit'] = $config['spoilages/add'] = array (
        array(
            'field' => 'branch_id_from',
            'label' => 'Branch',
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
        )    
);
