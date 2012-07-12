<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @package Suppliers
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2012-06-22
 */
class Suppliers extends MY_Controller {

    // --------------------------------------------------------------------

    public function __construct() {
        parent::__construct();                    
        
        $this->model = new ModelFactory('suppliers', 'supplier_id');
        
        $this->load->config('suppliers');
        $this->load->vars(array('suppliers_nav' => 'class="active"'));
    }

    // --------------------------------------------------------------------

    /**
     * This is the default action, lists all orders.
     *
     * @param int $page 
     */
    function index($page = 0)
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
            // Assign the value of $total to our view.
            $pagination['total_rows'] = $this->view_data['total'] = $total;
            $pagination['per_page']   = 30;
            $pagination['base_url']   = site_url('suppliers/index?');
            
            $this->paginate($pagination);

            $results = $this->model->fetch_all($pagination['per_page'], $page);

            $this->view_data['suppliers'] = $results->result();
        }

        $this->layout->view('list', $this->view_data);
    }        
}