<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['category/edit'] = $config['category/add'] = array (
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'trim|required'
        ),        
        array(
            'field' => 'markup',
            'label' => 'Markup',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'use_default_markup',
            'label' => 'Use default',
            'rules' => 'trim|required'
        )
);
