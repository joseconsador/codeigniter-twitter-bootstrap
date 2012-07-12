<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['item/edit'] = $config['item/add'] = array (
        array(
            'field' => 'item_code',
            'label' => 'Item Code',
            'rules' => 'trim|required'
        ),        
        array(
            'field' => 'name',
            'label' => 'Item name',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'category_id',
            'label' => 'Category',
            'rules' => 'trim|required'
        ),    
        array(
            'field' => 'markup',
            'label' => 'Markup',
            'rules' => 'trim|required'
        ),     
        array(
            'field' => 'use_default_markup',
            'label' => 'Use default markup',
            'rules' => 'trim|required'
        ),     
        array(
            'field' => 'initial_cost',
            'label' => 'Initial Cost',
            'rules' => 'trim|required'
        ),     
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
);
