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
class Purchasing extends MY_Controller {

    // --------------------------------------------------------------------

    public function __construct() {        
        parent::__construct();
        
        $this->_form_view = 'purchasing_edit';
        $this->load->config('purchasing');        
        
        $this->model = new ModelFactory('item_purchasing', 'item_purchasing_id');
        $this->suppliers = new ModelFactory('suppliers', 'supplier_id');

        $this->load->vars(array('purchasing_nav' => 'class="active"'));
    }

    // --------------------------------------------------------------------

    /**
     * This is the default action, lists all items.
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
            $pagination['base_url']   = site_url('items/index?');                        
            
            $this->paginate($pagination);
            $purchases = $this->model->fetch_all($pagination['per_page'], $page);
            $results = new tCollection('cPurchase', $purchases->result());

            $this->view_data['purchases'] = $results->getCollection();
        }

        $this->layout->view('purchasing_list', $this->view_data);
    }  

    function form($id = null) {
        $this->load->model('items');

        $items = $this->items->fetch_all();

        if ($items) {
            $this->load->vars(array('items_selection' => $items->result()));
        }
        
        parent::form($id);
    }    

    public function _save($validation, $model)
    {        
        $items = $this->input->post('items');
        $qty = $this->input->post('qty');        
        $cost = $this->input->post('cost');        

        foreach ($items as $i => $item) {
            $purchase = new cPurchase();

            $purchase->unit_price = $cost[$i];
            $purchase->item_id    = $item;
            $purchase->quantity   = $qty[$i];
            $purchase->supplier_id = $this->input->post('supplier_id');

            if ($purchase->save()) {
                $purchase->process();
            }
        }       
        
        return TRUE;     
    }    
}