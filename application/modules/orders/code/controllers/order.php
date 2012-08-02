<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @package order
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-08-03
 */
class Order extends MY_Controller {

    // --------------------------------------------------------------------

    public function __construct() {
        parent::__construct();        
        
        $this->load->model('orders', '' ,true);        
        
        $this->model = $this->orders;
        
        $this->load->config('orders');
        $this->load->vars(array('order_nav' => 'class="active"'));
    }

    // --------------------------------------------------------------------

    /**
     * This is the default action, lists all orders.
     *
     * @param int $page 
     */
    function index()
    {           
        $page = 0;

        if (isset($_GET['per_page'])) {
            $page = $_GET['per_page'];
        }

        $records = $this->model->fetch_all();
        // Get total number of records for pagination and display purposes.
        $total = $records->num_rows();

        if ($total > 0)
        {
            $per_page = 10;
            // Assign the value of $total to our view.
            
            $pagination['per_page']   = $per_page;
            $pagination['base_url']   = site_url('orders/index?');            

            if ($this->input->get('search') == 1) {
                $_POST = $_GET;                        

                $search = array();
                if ($this->input->get('control_number') != '') {
                    $search[] = array(
                            'field' => 'control_number',
                            'value' => $this->input->get('control_number'),
                            'type'  => 'cn'
                            );
                }

                if ($this->input->get('status') != '') {
                    $search[] = array(
                            'field' => 'status',
                            'value' => $this->input->get('status'),
                            'type'  => 'eq'
                            );
                }

                if ($this->input->get('branch_id') != '') {
                    $search[] = array(
                            'field' => 'branch_id',
                            'value' => $this->input->get('branch_id'),
                            'type'  => 'eq'
                            );
                }

                if ($this->input->get('date_start') != '') {
                    if ($this->input->get('date_end') != '') {                        
                        $search[] = array(
                            'field' => 'order.date_created',
                            'value' => date('Y-m-d H:i:s', strtotime($this->input->get('date_end'))),
                            'type'  => 'lte'
                            );

                    }

                    $search[] = array(
                            'field' => 'order.date_created',
                            'value' => date('Y-m-d H:i:s', strtotime($this->input->get('date_start'))),
                            'type'  => 'gte'
                            );
                }
                
                foreach ($_GET as $key => $q) {
                    if ($key != 'per_page') {
                        $query[$key] = $q;
                    }
                }

                $pagination['base_url'] .= '/?' . http_build_query($query);

                $results = $this->model->search(
                    $search,
                    '',
                    '', 
                    $pagination['per_page'], 
                    $page
                );      
                
                $total = $this->model->search($search, '')->num_rows();
            } else {
                $results = $this->model->fetch_all($pagination['per_page'], $page);                   
            }

            $pagination['total_rows'] = $this->view_data['total'] = $total;

            $this->paginate($pagination);
            $this->view_data['orders'] = $results->result();
        }

        $this->view_data['sort'] = array(
            '' => '',
            'control_number' => 'Control Number',
            'order.date_created' => 'Date Created',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'grand_total' => 'Grand Total'
            );        

        $this->layout->view('list', $this->view_data);
    }        
	
	// --------------------------------------------------------------------
	
	function form($id = null) {
		$this->load->model(array('items', 'order_item', 'model_inventory'));
		
		$items = $this->items->fetch_all();

        $order_items    = array();
        $client_address = array();
        $order_pickup   = array();

        if (!(is_null($id))) {            
            $order = $this->model->get($id);

            $this->load->vars(
                array(
                    'order_items'    => $order->order_items,
                    'client_address' => $order->client_address,
                    'order_pickup'   => $order->order_pickup,
                    'order_delivery' => $order->order_delivery
                    )
                );                            
        }        

		if ($items) {
			$this->load->vars(array('items_selection' => $items->result()));
		}
		
		parent::form($id);
	}

    // --------------------------------------------------------------------    

    function complete() {
        $order = new cOrder($this->input->post('order_id'));
        
        $order->received_by = $this->input->post('received_by');
        $order->date_completed = $this->input->post('date_completed');

        try {
            if ($order->completeOrder()) {
                $this->session->set_flashdata('message', 'Order marked as complete.');
            } else {
                $this->session->set_flashdata('message', 'Operation failed.');
            }
        } catch(Exception $e) {
            $this->session->set_flashdata('message', $e->getMessage());
        }

        redirect ('orders');
    }

    // --------------------------------------------------------------------    

    function get_sales() {
        if (!$this->input->is_ajax_request() && !$this->user->is_admin) {
            show_error('Insufficient access.');
        } else {
            $branch_id  = $this->input->post('branch_id');

            switch ($this->input->post('date_range')) {
                case '1':
                    $month = date('m');
                    $year  = date('Y');

                    $date_start = date('Y-m-01 00:00:00');
                    $date_end   = date('Y-m-t 23:59:59', mktime(0, 0, 0, $month, 1, $year));
                    break;
                case '2':
                    $date_end   = date('Y-m-d H:i:s');
                    $date_start = date('Y-m-d H:i:s', strtotime('-30 days', strtotime($date_end)));
                    break;
                case '3':
                    $date_end   = date('Y-m-d H:i:s');
                    $date_start = date('Y-m-d H:i:s', strtotime('-2 months', strtotime($date_end)));
                    break;
                case '4':
                    $date_end   = date('Y-m-d H:i:s');
                    $date_start = date('Y-m-d H:i:s', strtotime('-6 months', strtotime($date_end)));
                    break;
                case '5':
                    $date_end   = date('Y-m-d H:i:s');
                    $date_start = date('Y-m-d H:i:s', strtotime('-1 year', strtotime($date_end)));
                    break;
                case '6':
                    $date_end   = date('Y-m-d H:i:s');
                    $date_start = date('Y-m-d H:i:s', strtotime('-2 years', strtotime($date_end)));
                    break;
                default:
                    # code...
                    break;
            }

            $sales = $this->model->get_sales($branch_id, $date_start, $date_end);

            if ($sales) {                
                if (in_array($this->input->post('date_range'), array('5','6'))) {
                    foreach ($sales as $date => $sale) {
                        $index = date('M Y', strtotime($date));
                        
                        if (!isset($reponse[$index])) {                            
                            $response[$index] = $sale;
                        } else {
                            $response[$index] += $sale;
                        }
                    }
                } else {
                    $response = $sales;
                }
            } else {
                $response = FALSE;                 
            }

            $this->load->model('branches');

            $branches = $this->branches->fetch_all()->result();

            $data['json'] = array('response' => $response, 'branches' => $branches);

            $this->load->view('json', $data);
        }
    }
}