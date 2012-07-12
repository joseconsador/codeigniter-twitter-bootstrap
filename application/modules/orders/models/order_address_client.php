<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "order_address_client" table.
 *
 * @package ORders
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-11-19
 */
class Order_address_client extends MY_Model {

    private $_table_name = 'order_address_client';
    private $_primary_key = 'order_address_client_id';

    // --------------------------------------------------------------------

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }
}