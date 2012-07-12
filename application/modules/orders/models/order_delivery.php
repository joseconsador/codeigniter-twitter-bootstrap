<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "order_address_client" table.
 *
 * @package ORders
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-11-19
 */
class Order_delivery extends MY_Model {

    private $_table_name = 'order_delivery';
    private $_primary_key = 'order_delivery_id';

    // --------------------------------------------------------------------

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Handle saving or creating of new database entries.
    *  @param $params array Data to be stored.
    *  @return int
    */
    function do_save($params)
    {
    	$this->load->model('order_address');
    	
    	$params['order_address_id'] = $this->order_address->do_save($params);

    	$params['delivery_datetime'] = date('Y-m-d H:i:s', strtotime($params['delivery_datetime']));

        if (isset($params['order_id'])) {            
            if ($delivery = $this->get($params['order_id'], 'order_id')) {
                $params[$this->get_primary_key()] = $delivery->{$this->get_primary_key()};
            }
        }

    	return parent::do_save($params);
    }

    // --------------------------------------------------------------------

    function get($key, $field = '') {
        $this->db->join('order_address', 'order_address.order_address_id = ' . $this->get_table_name() . '.order_address_id');

        return parent::get($key, $field);
    }
}