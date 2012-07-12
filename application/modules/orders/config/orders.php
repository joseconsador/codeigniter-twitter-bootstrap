<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['order/edit'] = $config['order/add'] = array (
        array(
            'field' => 'branch_id',
            'label' => 'Branch',
            'rules' => 'trim|required'
        ),        
        array(
            'field' => 'user_id',
            'label' => 'Staff',
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
            'field' => 'client[]',
            'label' => 'Client info',
            'rules' => 'trim'
        ),        
        array(
            'field' => 'order_item[]',
            'label' => 'Client info',
            'rules' => 'trim|callback_check_inventory'
        ),    
        array(
            'field' => 'order_type',
            'label' => 'Select an order type',
            'rules' => 'trim|required'
        ),

        array(
            'field' => 'items_description',
            'label' => 'item description',
            'rules' => 'trim|required'
        ),        
        array(
            'field' => 'pickup[]',
            'label' => 'Pickup details',
            'rules' => 'trim|required'
        ),    
        array(
            'field' => 'delivery[]',
            'label' => 'Delivery details',
            'rules' => 'trim'
        ),            
        array(
            'field' => 'payment_type_id',
            'label' => 'Payment type',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'order_address_client_id',
            'label' => 'Order address client',
            'rules' => 'trim'
        ),
        array(
            'field' => 'delivery_cost',
            'label' => 'Order address client',
            'rules' => 'trim'
        ),
        array(
            'field' => 'special_cost',
            'label' => 'Order address client',
            'rules' => 'trim'
        ),
        array(
            'field' => 'final_cost',
            'label' => 'Final Cost',
            'rules' => 'trim'
        ),
        array(
            'field' => 'order_cost',
            'label' => 'Order Cost',
            'rules' => 'trim'
        )                
);
