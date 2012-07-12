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
class Model_inventory extends MY_Model {

    private $_table_name = 'item_inventory';
    private $_primary_key = 'item_inventory_id';

	// --------------------------------------------------------------------
	
    public function __construct() {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }
	
	// --------------------------------------------------------------------

    public function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc') {
        $this->load->model(array('items', 'branches'));

        $this->db->select(
            array(
                $this->_table_name . '.*', 
                'item.name as item_name', 
                'branches.name as branch_name', 
                'branches.branch_id'
                )
            );

        $this->db->join(
            $this->items->get_table_name(), 
            $this->items->get_table_name() . '.item_id = ' . $this->_table_name . '.item_id'
            );

        $this->db->join(
            $this->branches->get_table_name(),
            $this->branches->get_table_name() . '.branch_id = ' . $this->_table_name . '.branch_id');

        return parent::fetch_all($limit, $offset, $sort, $order);
    }	

    // --------------------------------------------------------------------

    /**
     * Add an entry to inventory history eveytime a write operation to this table occurs.     
     */
    public function do_save($params) {
        $return = parent::do_save($params);

        if ($return) {
            $this->load->model('model_inventory_history');
            $this->model_inventory_history->do_save($params);
        }

        return $return;
    }

    // --------------------------------------------------------------------

    public function get_available_items() {
        if (!$this->user->is_admin) {            
            $this->db->where($this->get_table_name() . '.branch_id', $this->user->branch_id);
        }
        
        $this->db->where('quantity >', 0);
        
        return $this->fetch_all();
    }

    // --------------------------------------------------------------------

    public function subtract_from_inventory($item_id, $branch_id, $quantity) {        
        $this->db->where('item_id', $item_id);
        $this->db->where('branch_id', $branch_id);
        $this->db->limit(1);

        $inventory = $this->db->get($this->get_table_name());

        if ($inventory->num_rows() == 0) {            
            return FALSE;
        }

        $curr_quantity   = $inventory->row()->quantity;
        $update_quantity = $curr_quantity - $quantity;

        $this->db->where($this->get_primary_key(), $inventory->row()->{$this->get_primary_key()});

        return $this->db->update($this->get_table_name(), array('quantity' => $update_quantity));
    }
}