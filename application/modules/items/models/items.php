<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "blog" table.
 *
 * @package Items
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-11-19
 */
class Items extends MY_Model {

    private $_table_name = 'item';
    private $_primary_key = 'item_id';

	// --------------------------------------------------------------------
	
    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }
    
	// --------------------------------------------------------------------
	
    public function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc') {
        $this->db->select('item.*');
        $this->db->select('item_category.name as category');
        $this->db->join('item_category', 'item.category_id = item_category.category_id');
        
        return parent::fetch_all($limit, $offset, $sort, $order);
    }
	
	// --------------------------------------------------------------------
	
	public function get_item_qty_cost($item_id, $qty) {
		if (!(is_object($item_id))) {
			$item = $this->get($item_id);			
		} else {
			$item = $item_id;
		}
				
		$unit_cost = $this->get_unit_cost($item);
		
		return $unit_cost * $qty;
	}

	// --------------------------------------------------------------------

	public function get_unit_cost($item) {
		if (!(is_object($item))) {
			$item = $this->get($item);
		}

		return $item->initial_cost + $this->get_markup($item);
	}
	
	// --------------------------------------------------------------------
	
	public function get_markup($item) {
		if (!(is_object($item))) {
			$item = $this->get($item);
		}
		
		if ($item->use_default_markup) {
			$this->load->model('categories');
			$category = $this->categories->get_markup($item->category_id);
		} else {
			return $item->markup;
		}
	}
}