<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['purchasing/edit'] = $config['purchasing/add'] = array (
        array(
            'field' => 'supplier_id',
            'label' => 'Supplier',
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
