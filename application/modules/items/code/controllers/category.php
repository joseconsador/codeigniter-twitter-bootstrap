<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 * @package Categories
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-08-03
 */
class Category extends MY_Controller {

    // --------------------------------------------------------------------

    public function __construct() {
        parent::__construct();                
        $this->load->model('categories', '' ,true);        
        
        $this->model = $this->categories;
        $this->_form_view = 'category_edit';        
        $this->load->config('categories');

        $this->load->vars(array('catalog_nav' => 'class="active"'));
    }

    // --------------------------------------------------------------------

    /**
     * This is the default action, lists all categories.
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
            $pagination['base_url']   = site_url('items/categories/index?');                        
            
            $this->paginate($pagination);

            $results = $this->model->fetch_all($pagination['per_page'], $page);

            $this->view_data['categories'] = $results->result();
        }

        $this->layout->view('category_list', $this->view_data);
    }        
    
    /**
     * This is the default action, lists all categories.
     *
     * @param int $page 
     */
    /**
    function index($page = 0) {
        $this->view_data['grid_caption'] = 'Categories';
        $this->view_data['column_names'] = array('ID', 'Name', 'Markup', 'Use Default Markup', 'Updated');
        $this->view_data['column_model'] = array (
            array (
                'name' => $this->model->get_primary_key(), 
                'index' => $this->model->get_primary_key(),                
                'sortable' => true
                ),      
            array (
                'name' => 'name', 
                'index' => 'name',                
                'sortable' => true,
                'editable' => true
                ),
            array (
                'name' => 'markup', 
                'index' => 'markup',                
                'sortable' => true
                ),
            array (
                'name' => 'use_default_markup',
                'index' => 'use_default_markup',                
                'sortable' => true
                ),            
            array (
                'name' => 'date_updated', 
                'index' => 'date_updated',                
                'sortable' => true
                ),            
        );
        
        $this->view_data['default_sort'] = $this->model->get_primary_key();        
        $this->view_data['edit_url'] = site_url('items/categories/form');
        
        $this->layout->view('jqgrid', $this->view_data);
    }   
     * 
     */
}