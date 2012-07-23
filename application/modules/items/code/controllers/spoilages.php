<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @package item
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2012-06-22
 */
class Spoilages extends MY_Controller {

    // --------------------------------------------------------------------

    public function __construct() {        
        parent::__construct();
        
        $this->_form_view = 'spoilages_edit';
        $this->load->config('spoilages');        
        
        $this->model = new ModelFactory('item_inventory_spoilage', 'item_inventory_spoilage_id');
        $this->load->vars(array('catalog_nav' => 'class="active"'));
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
            $per_page = 10;
            // Assign the value of $total to our view.
            
            $pagination['per_page']   = $per_page;
            $pagination['base_url']   = site_url('items/inventory/spoilages');            

            if ($this->input->get('search') == 1) {
                $_POST = $_GET;                        

                $search = array();
                if ($this->input->get('created_by') != '') {
                    $search[] = array(
                            'field' => 'created_by',
                            'value' => $this->input->get('created_by'),
                            'type'  => 'eq'
                            );
                }

                foreach ($_GET as $key => $q) {
                    if ($key != 'per_page') {
                        $query[$key] = $q;
                    }
                }

                $pagination['base_url'] .= '/?' . http_build_query($query);

                $spoilages = $this->model->search(
                    $search,
                    '',
                    '', 
                    $pagination['per_page'], 
                    $page
                );      
                
                $total = $this->model->search($search, '')->num_rows();
            } else {
                $spoilages = $this->model->fetch_all($pagination['per_page'], $page);                   
            }

            $results = new tCollection('cSpoilage', $spoilages->result());
            $pagination['total_rows'] = $this->view_data['total'] = $total;

            $this->paginate($pagination);

            $this->view_data['spoilages'] = $results->getCollection();
        }

        $this->view_data['sort'] = array(
            '' => '',            
            'item_inventory_id' => 'Item',
            'created_by' => 'Staff',
            'quantity' => 'Quantity',
            'amount' => 'Price'
            );        

        $this->layout->view('spoilage_list', $this->view_data);
    }  

    public function _save($validation, $model)
    {        
        $items = $this->input->post('items');
        $qty = $this->input->post('qty');        

        foreach ($items as $i => $item) {
            $inventory_item = new cInventory($item);
            $item = $inventory_item->getItem();

            $spoilage = new cSpoilage();

            $spoilage->amount             = $item->getModel()->get_item_qty_cost($item->item_id, $qty[$i]);
            $spoilage->item_inventory_id = $inventory_item->item_inventory_id;
            $spoilage->quantity          = $qty[$i];

            if ($spoilage->save()) {
                $spoilage->process();
            }
        }       
        
        return TRUE;     
    }    
}