<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @package item
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2012-03-13
 */
class Inventory extends MY_Controller {

    // --------------------------------------------------------------------

    public function __construct() {        
        parent::__construct();        
                
        $this->load->model('model_inventory', 'model' ,true);        
                
        $this->_form_view = 'item_inventory_edit';
        $this->load->config('inventory');

        $this->load->vars(
            array(
                'catalog_nav' => 'class="active"',
                'inventory_nav' => 'class="active"'
            )
        );
    }

    // --------------------------------------------------------------------

    /**
     * This is the default action, lists all items.
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
            // Assign the value of $total to our view.
            $pagination['total_rows'] = $this->view_data['total'] = $total;
            $pagination['per_page']   = 30;
            $pagination['base_url']   = site_url('items/inventory/index?');                        
            
            $this->paginate($pagination);

            if ($this->input->get('search') == 1) {
                $_POST = $_GET;           
                $search = array();

                if ($this->input->get('item_name') != '') {                                    
                    $search[] = array(
                            'field' => 'item.name',
                            'value' => $this->input->get('item_name'),
                            'type'  => 'cn'
                            );
                }

                if ($this->input->get('branch_id') > 0) {
                    $search[] = array(
                            'field' => 'branches.branch_id',
                            'value' => $this->input->get('branch_id'),
                            'type'  => 'eq'
                            );
                }

                if ($this->input->get('quantity') != '') {
                    $search[] = array(
                            'field' => 'quantity',
                            'value' => $this->input->get('quantity'),
                            'type'  => $this->input->get('qty_type')
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

            $this->view_data['inventory'] = $results->result();
        }

        $this->layout->view('item_inventory_list', $this->view_data);
    }

    // --------------------------------------------------------------------

    public function get_item() {
        if ($this->input->is_ajax_request()) {
            $item = $this->model->get($this->input->post('item_inventory_id'));
            
            $this->load->view('json', array('json' => $item));
        } else {
            show_404();
        }
    }

    public function get_branch_inventory() {
        if ($this->input->is_ajax_request()) {
            
            $branch_inventory = new cBranchInventory($this->input->post('branch_id'));
            $c = $branch_inventory->getCollection();

            foreach ($c as $item) {
                $item->name = $item->getItem()->name;
            }

            $this->load->view('json', array('json' => $c));
        } else {
            show_404();
        }
    }
}