<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "orders" table.
 *
 * @package ORders
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-11-19
 */
class Orders extends MY_Model {

    private $_table_name = 'order';
    private $_primary_key = 'order_id';

    // --------------------------------------------------------------------

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    // --------------------------------------------------------------------

    function do_save($params) {    
		$order_id = parent::do_save($params);

		if ($order_id) {	
            $params[$this->get_primary_key()] = $order_id;
            
	    	$this->load->model(array('order_item', 'order_address_client', 'order_pickup', 'order_delivery', 'model_inventory'));
	    	
            // Save order_items.
            $this->order_item->save_order_items($order_id, $params['items'], $params['qty']);

            // Get subtotal.
            $params['subtotal'] = $this->get_subtotal($order_id);

            // Get grandtotal.
            $params['grand_total'] = $params['order_cost'] + $params['delivery_cost'] + $params['special_cost'];

            // Save client info.
            if ($this->input->post('order_address_client_id')) {
                $params['client']['order_address_client_id'] = $this->input->post('order_address_client_id');
            }

            $params['order_address_client_id'] = $this->order_address_client->do_save($params['client']);

            // Save order type info.
            if ($params['order_type'] == 1) {
                $params['pickup']['order_id'] = $order_id;
                $this->order_pickup->do_save($params['pickup']);
            } else {
                $params['delivery']['order_id'] = $order_id;       
                $this->order_delivery->do_save($params['delivery']);                
            }                        

            $params['increment']      = $this->get_increment($params[$this->get_primary_key()]);
            $params['control_number'] = $this->get_control_number($params[$this->get_primary_key()]);                                     

            $order_id = parent::do_save($params);
		}

    	return $order_id;
    }

    // --------------------------------------------------------------------

    function do_create($params) {
        $params['status'] = 'Paid';    

        return parent::do_create($params);
    }

    // --------------------------------------------------------------------
    
    function get_control_number($order_id) {
        $order = $this->get($order_id);

        if ($order) {
            if ($order->control_number == '' || $order->control_number == 0 || is_null($order->control_number)) {
                $this->load->model('branches');
                
                $branch      = $this->branches->get($order->branch_id);
                $branch_code = $branch->branch_code;
                $increment   = $this->get_increment($order);

                $control_number = $branch_code . $increment;
            } else {
                $control_number = $order->control_number;
            }

            return $control_number;
        } else {
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    function get_increment($order) {
        if (!is_object($order)) {
            $order = $this->get($order);
        }

        if ($order->increment > 0) {
            return $order->increment;
        }

        $this->db->order_by('increment');

        $branch_orders = parent::get($order->branch_id, 'branch_id');

        if (count($branch_orders) > 1) {
            $last_order = end($branch_orders);    
        } else {
            $last_order = $branch_orders;
        }
        
        return (is_null($last_order->increment)) ? 1 : $last_order->increment + 1;
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Return subtotal or compute subtotal if subtotal is still equal to zero.
    *
    *  @param  int $order_id
    *  @return mixed
    */
    function get_subtotal($order_id) {
        $order = $this->get($order_id);

        if ($order) {
            if ($order->subtotal == 0) {
                $this->load->model('order_item');
                
                $order_items = $this->order_item->get($order_id, 'order_id');
                $subtotal    = $this->order_item->get_subtotal($order_items);

                parent::do_save(array($this->get_primary_key() => $order_id, 'subtotal' => $subtotal));

                $order = $this->get($order_id);
            }
            
            return $order->subtotal;
        } else {
            show_error('Order does not exist.');
        }
    }

    // --------------------------------------------------------------------

    function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc') {
        if (!$this->user->is_admin) {
            $this->db->where('branch_id', $this->user->branch_id);
        }

        $this->db->join('order_address_client', 
                        $this->get_table_name() . '.order_address_client_id = order_address_client.order_address_client_id',
                        'left');
                        
        $this->db->where('deleted', 0);
                                
        return parent::fetch_all($limit, $offset, $sort, $order);
    }

    // --------------------------------------------------------------------

    function get($id) {
        $this->db->select($this->get_table_name() . '.*');
        $this->db->select('branches.name as branch');
        $this->db->select('user.firstname as staff_firstname, user.lastname as staff_lastname');
        $this->db->select('order_type.name as order_type_name');
        $this->db->select('payment_type.name as payment_type');

        $this->db->join('branches', 'branches.branch_id = ' . $this->get_table_name() . '.branch_id');
        $this->db->join('user', 'user.user_id = ' . $this->get_table_name() . '.user_id');
        $this->db->join('order_type', 'order_type.order_type_id = ' . $this->get_table_name() . '.order_type');
        $this->db->join('payment_type', 'payment_type.payment_type_id = ' . $this->get_table_name() . '.payment_type_id');

        $this->db->where('deleted', 0);

        $order = parent::get($id);

        if ($order) {
            $this->load->model(array('order_address_client', 'order_item', 'order_pickup', 'order_delivery'));

            $order->order_items    = cOrderItem::getByOrderId($id);            
            $order->client_address = $this->order_address_client->get($order->order_address_client_id);
            $order->order_pickup   = $this->order_pickup->get($id, $this->model->get_primary_key());
            $order->order_delivery = $this->order_delivery->get($id, $this->model->get_primary_key());            
        }
        
        return $order;   
    }

    // --------------------------------------------------------------------

    function delete($key)
    {
        if (!is_array($key))
        {
            $key = array($key);
        }

        $this->db->where_in($this->get_table_name() . '.' . $this->get_primary_key(), $key);
        return $this->db->update($this->get_table_name(), array('deleted' => 1, 'status' => 'Deleted'));
    }

    // --------------------------------------------------------------------

    function get_sales($branch_id, $date_start, $date_end)
    {
        if (trim($branch_id) != '') {
            $this->db->where($this->get_table_name() . '.branch_id', $branch_id);            
        }

        $this->db->select($this->get_table_name() . '.*, branches.name AS branch_name');
        
        $this->db->join('branches', 'branches.branch_id = ' . $this->get_table_name() . '.branch_id', 'left');

        $this->db->where($this->get_table_name() . '.date_created <=', $date_end);
        $this->db->where($this->get_table_name() . '.date_created >=', $date_start);
        $this->db->where($this->get_table_name() . '.deleted', 0);

        $result = $this->db->get($this->get_table_name());

        if (!isset($result) && $result->num_rows() == 0) {
            return FALSE;
        } else {
            $sales = array();

            foreach ($result->result() as $order) {
                $index = date('Y-m-d', strtotime($order->date_created));

                if (isset($sales[$index])) {
                    $sales[$index] += (int) $order->grand_total;
                } else {
                    $sales[$index] = (int) $order->grand_total;
                }

            }

            return (count($sales) > 0) ? $sales : FALSE;
        }
    }
}