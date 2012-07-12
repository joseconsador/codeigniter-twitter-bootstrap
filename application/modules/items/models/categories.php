<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Model for interacting with the "categories" table.
 *
 * @package Items
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-11-19
 */
class Categories extends MY_Model {

    private $_table_name = 'item_category';
    private $_primary_key = 'category_id';

	// --------------------------------------------------------------------
	
    public function __construct() {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }
	
	// --------------------------------------------------------------------

    public function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc') {
        $this->db->select('category_id');
        $this->db->select('name');
        $this->db->select('markup');
        $this->db->select('use_default_markup');
        $this->db->select('date_updated');

        return parent::fetch_all($limit, $offset, $sort, $order);
    }
	
	// --------------------------------------------------------------------
	
	public function get_markup($category_id) {
		$category = $this->get($category_id);
		
		return ($category) ? $category->markup : FALSE;
	}
}