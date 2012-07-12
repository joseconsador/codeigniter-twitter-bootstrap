<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Model for interacting with the "categories" table.
 *
 * @package Items
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2012-03-13
 */
class Model_inventory_history extends MY_Model {

    private $_table_name = 'item_inventory_history';
    private $_primary_key = 'item_inventory_history_id';

	// --------------------------------------------------------------------
	
    public function __construct() {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }
}