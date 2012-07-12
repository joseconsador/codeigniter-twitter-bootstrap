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
class Model_transfers extends MY_Model {

    private $_table_name = 'inventory_transfer';
    private $_primary_key = 'inventory_transfer_id';

	// --------------------------------------------------------------------
	
    public function __construct() {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc') {
        if (!$this->user->is_admin) {
            $this->db->where('branch_id_from', $this->user->branch_id);
            $this->db->or_where('branch_id_to', $this->user->branch_id);
        }

        return parent::fetch_all($limit, $offset, $sort, $order);
    }    
}