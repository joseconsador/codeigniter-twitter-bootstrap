<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "order_address_client" table.
 *
 * @package ORders
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-11-19
 */
class Order_address extends MY_Model {

    private $_table_name = 'order_address';
    private $_primary_key = 'order_address_id';

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
        $fields = $this->db->list_fields($this->get_table_name());
        
        // Save only fields on database, so we don't have to use unset($params[]) to often.
        $valid_fields = array_intersect($fields, array_keys($params));

        foreach ($valid_fields as $field) {
            $data[$field] = $params[$field];
        }

        $data['date_updated'] = date('Y-m-d H:i:s');
        $order = $this->get($data['order_id'], 'order_id');        

        if ($order != FALSE)
        {
            $data[$this->get_primary_key()] = $order->{$this->get_primary_key()};
            return $this->do_update($data);
        }
        else
        {
            $data['date_created'] = date('Y-m-d H:i:s');
            return $this->do_create($data);
        }
    }      
}