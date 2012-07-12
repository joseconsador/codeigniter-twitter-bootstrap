<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @package Branches
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-08-03
 */
class Branch extends MY_Controller {

    // --------------------------------------------------------------------

    public function __construct() {
        parent::__construct();        
        
        $this->load->model('branches', '' ,true);        
        
        $this->model = $this->branches;                
        
        $this->load->config('branches');
        $this->load->vars(array('branch_nav' => 'class="active"'));
    }

    // --------------------------------------------------------------------

    /**
     * This is the default action, lists all orders.
     *
     * @param int $page 
     */
    function index($page = 0)
    {                
        $records = $this->model->fetch_all();
        // Get total number of records for pagination and display purposes.
        $total = $records->num_rows();

        if ($total > 0)
        {
            // Assign the value of $total to our view.
            $pagination['total_rows'] = $this->view_data['total'] = $total;
            $pagination['per_page']   = 30;
            $pagination['base_url']   = site_url('branch/index/');
            
            $this->paginate($pagination);

            $results = $this->model->fetch_all($pagination['per_page'], $page);

            $this->view_data['branches'] = $results->result();
        }

        $this->layout->view('list', $this->view_data);
    }        
}