<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @package item
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-08-03
 */
class Item extends MY_Controller {

    // --------------------------------------------------------------------

    public function __construct() {        
        parent::__construct();        
        $this->load->helper('categories');
        
        $this->load->model('items', '' ,true);        
        
        $this->model = $this->items;
        $this->_form_view = 'item_edit';
        $this->load->config('items');

        $this->load->vars(array('item_nav' => 'class="active"'));
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
            $pagination['per_page']   = 30;
            $pagination['base_url']   = site_url('items/index?');

            if ($this->input->get('search') == 1) {
                $_POST = $_GET;
                $search = array();

                if ($this->input->get('name') != '') {                                    
                    $search[] = array(
                            'field' => 'item.name',
                            'value' => $this->input->get('name'),
                            'type'  => 'cn'
                            );
                }

                if ($this->input->get('category_id') > 0) {
                    $search[] = array(
                            'field' => 'item.category_id',
                            'value' => $this->input->get('category_id'),
                            'type'  => 'eq'
                            );
                }

                if ($this->input->get('price') != '') {
                    $search[] = array(
                            'field' => 'initial_cost',
                            'value' => $this->input->get('price'),
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

            $this->view_data['items'] = $results->result();
        }
        
        $pagination['total_rows'] = $this->view_data['total'] = $total;
        
        $this->paginate($pagination);

        $this->layout->view('item_list', $this->view_data);
    }     
    
    // --------------------------------------------------------------------
    
    public function get_items() {
        if ($this->input->is_ajax_request()) {
            $items = $this->model->fetch_all();
            
            $response = array();
            $ctr      = 0;
            foreach ($items->result() as $item) {
                $response[$ctr]['value']    = $item->item_id;
                $response[$ctr]['label']    = $item->name;
                $response[$ctr]['category'] = $item->category;
                
                $ctr++;
            }
            
            $this->load->view('json', array('json' => $response));
        } else {
            show_404();
        }
    }
	
	// --------------------------------------------------------------------
	
	public function get_item_cost() {
        if ($this->input->is_ajax_request()) {
            $cost = $this->model->get_item_qty_cost($this->input->post('item_id'), $this->input->post('qty')); 
			$response['cost'] = $cost;
			
            $this->load->view('json', array('json' => $response));
        } else {
            show_404();
        }
	}


    // --------------------------------------------------------------------

    public function get_item() {
        if ($this->input->is_ajax_request()) {
            $item = $this->model->get($this->input->post('item_id'));             
            
            $this->load->view('json', array('json' => $item));
        } else {
            show_404();
        }        
    }    
}