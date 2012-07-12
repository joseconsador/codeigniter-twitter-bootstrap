<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "order_items" table.
 *
 * @package Orders
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-11-19
 */
class Order_item extends MY_Model {

    private $_table_name = 'order_item';
    private $_primary_key = 'order_item_id';

    // --------------------------------------------------------------------

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    // --------------------------------------------------------------------

    function save_order_items($order_id = 0, $items, $qty) {
        if (count($items) != count($qty)) {
            show_error('Number of items does not match quantity specified');
        }
        
        foreach ($items as $index => $item) {
            $i = new cInventory($item);

            $data['order_id']  = $order_id;
            $data['item_id']   = $item;
            $data['quantity']  = $qty[$index];
            $data['unit_cost'] = $this->items->get_unit_cost($i->getItem()->item_id);
 
            if (!$this->do_save($data)) 
            {                                
                return false;
            }
        }

        return true;
    }

    public function get_by_order_id($id) {        
        return $this->get($id, 'order_id');
    }

    // --------------------------------------------------------------------

    /**
    *
    * Return subtotal for given items.    
    *
    * @param  object Collection of order item.
    * 
    * @return int
    */
    function get_subtotal($items) {
        if (count($items) > 0) {
            $subtotal = 0;

            if (!is_array($items)) {
                $items = array($items);
            }

            foreach ($items as $item) {
                $subtotal += ($item->unit_cost * $item->quantity);
            }

            return $subtotal;
        } else {
            show_error('No item/s specified.');
        }
    }
}