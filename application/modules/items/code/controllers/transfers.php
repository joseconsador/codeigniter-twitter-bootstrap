<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @package item
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2012-06-21
 */
class Transfers extends MY_Controller {

    // --------------------------------------------------------------------

    public function __construct() {        
        parent::__construct();
        
        $this->_form_view = 'transfer_edit';
        $this->load->config('transfers');
        $this->load->model('model_transfers', '' ,true);        
        
        $this->model = $this->model_transfers;
        $this->load->vars(array('transfers_nav' => 'class="active"'));
    }

    // --------------------------------------------------------------------

    /**
     * This is the default action, lists all items.
     *
     * @param int $page 
     */
    function index($page = 0)
    {
        $records = cTransfer::fetchAll();
        // Get total number of records for pagination and display purposes.
        $total = $records->num_rows();

        if ($total > 0)
        {
            // Assign the value of $total to our view.
            $pagination['total_rows'] = $this->view_data['total'] = $total;
            $pagination['per_page']   = 30;
            $pagination['base_url']   = site_url('transfers/index?');                        
            
            $this->paginate($pagination);
            $transfers = $this->model->fetch_all($pagination['per_page'], $page);
            $results = new tCollection('cTransfer', $transfers->result());

            $this->view_data['transfers'] = $results->getCollection();
        }

        $this->layout->view('transfer_list', $this->view_data);
    }

    public function _save($validation, $model)
    {
        $id = parent::_save($validation, $model);
        
        if ($id) {
            $transfer = new cTransfer($id);
            $items = $this->input->post('items');
            $qty = $this->input->post('qty');

            $this->load->model('items');

            foreach ($items as $i => $item) {
                $inventory_item = new cInventory($item);
                $item = $inventory_item->getItem();

                $_item['price']             = $item->getModel()->get_item_qty_cost($item->item_id, $qty[$i]);
                $_item['item_inventory_id'] = $inventory_item->item_inventory_id;
                $_item['quantity']          = $qty[$i];

                $transfer->addItem($_item);
            }

            return $transfer->save();
        } else {
            return FALSE;
        }
    }   

    function view($id) 
    {
        $transfer = new cTransfer($id);

        if ($transfer->inventory_transfer_id == 0) {
            show_404();
        } else {
            $this->layout->view('transfer_view', array('transfer' => $transfer));
        }
    }

    function delete($id = null) {
        if ($this->input->post('id') || $id > 0) {
            if (is_null($id)) {
                $id = explode(',', $this->input->post('id'));
            }

            $transfer = new cTransfer($id);

            if ($transfer->delete()) {
                $message = 'Entry/s successfully deleted.';
                $response = 1;
            } else {
                if ($transfer->approved) {
                    $message = 'Completed transfers cannot be deleted.';
                } else {
                    $message = 'Could not delete the entry.';
                }

                $response = 0;
            }

            if ($this->input->is_ajax_request()) {
                echo json_encode(array('message' => $message, 'response' => $response));
                exit();
            } else {
                $this->session->set_flashdata('message', $message);
            }
        }

        redirect('/');
    }

    function approve()
    {
        if (!$this->user->is_admin) {
            $this->session->set_flashdata('message', 'Insufficient access.');
            redirect('/');
        } else {
            $transfer = new cTransfer($this->input->post('inventory_transfer_id'));
            $transfer->approve();    
            $this->session->set_flashdata('message', 'Transfer Complete.');
            redirect('items/inventory/transfers');
        }
    }
}