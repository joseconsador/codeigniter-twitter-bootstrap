<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @package Staff
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-08-03
 */
class User extends MY_Controller {

    // --------------------------------------------------------------------

    public function __construct() {
        parent::__construct();        
        
        $this->load->model('users', '' ,true);        
        
        $this->model = $this->users;                
        
        $this->load->config('staff');

        $this->load->vars(array('staff_nav' => 'class="active"'));
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
            $pagination['base_url']   = site_url('staff/index?');
            
            $this->paginate($pagination);

            $results = $this->model->fetch_all($pagination['per_page'], $page);

            $this->view_data['users'] = $results->result();
        }

        $this->layout->view('list', $this->view_data);
    }        
}