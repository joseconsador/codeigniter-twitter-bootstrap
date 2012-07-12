<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Place application wide pre-configuration/auth/initialization on this file.
 *
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-04-15
 */

class MY_Controller extends CI_Controller {
    
    private $_current_module;
    private $_current_action;

    protected $_form_data;
    protected $_form_view   = 'edit';
    protected $_detail_view = 'view';

    public $view_data, $user;

    // --------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();                       
                               
        if (!is_logged_in() && $this->uri->segment(1) != 'auth') {
            redirect ('auth/login');
        }

        $this->load->model('user_model');

        if (is_logged_in()) {            	
            $this->user = new cUser($this->session->userdata('user_id'));
            $this->user->is_admin = $this->is_admin();
        }        

        // Load asset paths config.
        $this->load->config('dir');

        // Load directory helper.
        $this->load->helper('dir');

        $this->_define_current_module();
        
        // Loads module packages.
        $this->_load_module_packages();

        // Determine what template to use.
        $this->_define_template();
                
        $this->_prep_view_data();           
    }

    // --------------------------------------------------------------------    
    
    /**
     * Have to remap the call to the controller in case there are some uri segments issues.
     */    
    function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            if (isset($params[0]) && $method == $params[0])
            {
                unset($params[0]);
            }
            
            return call_user_func_array(array($this, $method), $params);
        }
    }
    
    // --------------------------------------------------------------------    
    
    /**
     * Loads the dir of all modules that we have.
     */      
    function _load_module_packages()
    {
        $this->load->config('modules');
        
        $modules = $this->config->item('modules');
        
        foreach ($modules as $module)
        {
            $this->load->add_package_path(MODPATH . $module);
        }
    }   

    // --------------------------------------------------------------------

    /**
     * Start populating $this->view_data which will contain the parameters to be parsed
     * on the template.
     */
    private function _prep_view_data()
    {
        $this->view_data = array();        
    }

    // --------------------------------------------------------------------
    
    /**
     * Determines which template to use depending on the current location.
     */
    private function _define_template()
    {
        // Load our custom layout library.
        $this->load->library('layout');
        $this->layout->setLayout('layout/base');
    }

    // --------------------------------------------------------------------

    /**
     * Returns the current module being accessed.
     * 
     * @return string.
     */
    public function get_current_module()
    {
        return $this->_current_module;
    }

    // --------------------------------------------------------------------

    /**
     * Returns the current action being accessed.
     * 
     * @return string.
     */
    public function get_current_action()
    {
        return $this->_current_action;
    }  
    
    // --------------------------------------------------------------------

    /**
     * Override current_action.
     * 
     * @return string.
     */    
    public function set_current_action($action) {
        $this->_current_action = $action;
    }

    // --------------------------------------------------------------------

    /**
     * Initialize the pagination.
     *
     * @param array $params Array of configuration params
     */
    public function paginate($params = null)
    {
        $this->load->library('pagination');

        $config = $params;

        $config['per_page'] = isset($params['per_page']) ? $params['per_page'] : 10;                

        // Get the uri_segment for pagination, it's usually the segment after the current action.
        $uri_segment = array_keys($this->uri->segment_array(), $this->get_current_action());

        if (isset($uri_segment[0]) && !isset($params['uri_segment']))
        {
            $config['uri_segment'] = $uri_segment[0] + 1;
        }

        $config['full_tag_open'] = '<div class="pagination"><ul>';
        $config['full_tag_close'] = '</ul></div>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';        
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['page_query_string'] = TRUE;    

        $this->pagination->initialize($config);
    }

    // --------------------------------------------------------------------

    /**
     * Tell the controller to load the form validation library and set delimiter.
     *
     * @param array $rules
     */
    function require_validation($rules = null)
    {     
        $this->load->library('form_validation');

        // Try to look for a controller/method match in the config.
        if (is_null($rules))
        {
            $rules = $this->_current_module . '/' . $this->_current_action;
        }        
        
        $this->form_validation->set_error_delimiters('<label class="error">', '</label>');

        $conf = $this->config->item($rules);

        if (is_array($conf) && count($conf) > 0)
        {
            $this->form_validation->set_rules($conf);
        }
        else
        {
            show_error('No validation configuration specified.');
        }
    }

    // --------------------------------------------------------------------

    /**
     *
     * Handles file upload for all controllers, returns the encrypted name.
     *
     * @param string $filename    
     * @return mixed FALSE on error, the name of the uploaded file on success.
     */
    public function handle_file_upload($filename)
    {
        // Load the configuration of upload paths per module.
        $this->load->config('upload_path');
        $this->load->config('upload_config');
    
        $upload_paths = $this->config->item('upload_path');

        if (!isset($_FILES[$filename]) || $_FILES[$filename]['error'] == 4) // No file was uploaded.
        {        
            $this->session->set_userdata('file_' . $filename, ' ');
            return TRUE;
        }
		
        $config = $this->config->item($this->get_current_module() . '/' . $this->get_current_action());

        $config['upload_path'] = './uploads/';

        // Is there a set upload path for this module?
        // $this->router->fetch_class() gets the current controller, not the current module/page.
        if (isset($upload_paths[$this->router->fetch_class()]))
        {
            $upload_path = $config['upload_path'] . $upload_paths[$this->router->fetch_class()];
            
            if (!is_dir($upload_path)) // Create dir if it does not exist.
            {
                if (!mkdir($upload_path))
                {
                    $upload_path = $config['upload_path'];
                }
            }
            
            $config['upload_path'] = $upload_path;
        }
			    
        $this->load->library('upload', $config);

        // Upload and validate.
        if (!$this->upload->do_upload($filename))
        {
            $this->form_validation->set_message('handle_file_upload', $this->upload->display_errors());

            return FALSE;
        }
        else
        {
            // Save the encrypted file name to a session. DO NOT FORGET TO UNSET THIS.
            $this->session->set_userdata('file_' . $filename, $this->upload->file_name);
            
            $this->session->set_userdata('orig_file_' . $filename, $_FILES[$filename]['name']);            
            return TRUE; // Upload successful.
        }
    }

    // --------------------------------------------------------------------
    
    private function _define_current_module()
    {
        $this->_current_action = $this->router->method;

        $this->_current_module = $this->router->class;
    }

    // --------------------------------------------------------------------

    /**
     * Repopulate form values.
     *
     * @param string $config
     * @param object $defaults
     *
     * @return null
     */
    public function _prep_form_values($config = null, $defaults = null)
    {
        // Try to look for a controller/method match in the config.
        if (is_null($config))
        {
            $config = $this->_current_module . '/' . $this->_current_action;
        }
        
        $config = $this->config->item($config);

        if (!$config || !is_array($config) && count($config) == 0)
        {
            show_error('No validation configuration specified.');
        }

        foreach ($config as $field)
        {
            if (!is_null($defaults) && is_object($defaults))
            {
                // Check if defined field is an array.
                if (stripos($field['field'], '[]'))
                {
                    $field['field'] = trim($field['field'], '[]');
                    
                    $this->_form_data[$field['field']] = $this->input->post($field['field']);                    
        		}                                
                else if (isset($defaults->{$field['field']}))
                {
                    $this->_form_data[$field['field']] = set_value($field['field'], $defaults->{$field['field']});
                }
            }
            else
            {
                // Check if defined field is an array.
                if (stripos($field['field'], '[]'))
                {
                    $field['field'] = trim($field['field'], '[]');

                    $this->_form_data[$field['field']] = $this->input->post($field['field']);
                }
                else
                {
                    $this->_form_data[$field['field']] = set_value($field['field']);
                }
            }
        }

        // Merge form data to view data so we can use it in the view.
        $this->view_data = array_merge($this->view_data, $this->_form_data);
    }

    // --------------------------------------------------------------------

    /**
     * Save form data after validation.
     *
     * @param string $validation The name of the config item.
     * @param obj $model Instance of model to be used, must inherit MY_Model.
     * @return bool
     */
    public function _save($validation, $model)
    {
        $this->require_validation($validation);

        if ($this->form_validation->run())
        {   
            $this->db->trans_start();

            $record_id = $model->do_save($this->_form_data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return FALSE;
            } else {
                return $record_id;   
            }            
        }

        return FALSE;
    } 
    
    // --------------------------------------------------------------------
    /**
     * Handle jqgrid interactions and routing.
     */
    function action() {
        switch ($this->input->post('oper')) {
            case 'edit':
                $this->set_current_action('edit');
                $this->edit();
                break;
            case 'del':
                $this->set_current_action('delete');
                $this->delete();
                break;            
            case 'add':
                $this->set_current_action('add');
                $this->add();
                break;            
        }
    }        

    // --------------------------------------------------------------------

    /**
     * Edit an entry.
     *
     * @param int $id
     *
     */
    function edit($id = null) {
        if (is_null($id) && $this->input->is_ajax_request()) {
            $id = $this->input->post('id');            
        }
        
        if ($category = $this->model->get($id)) {            
            $this->_prep_form_values(null, $category);
        } else {
            $this->_prep_form_values();
        }
        
        $this->_form_data[$this->model->get_primary_key()] = $id;
        
        if ($this->input->post('submit') || $this->input->is_ajax_request()) {            
            $id = $this->_save(null, $this->model);

            if ($id) {
                print ($id);                
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * View an entry.
     *
     * @param int $id
     *
     */
    function view($id = null) {
        if (is_null($id) && $this->input->is_ajax_request()) {
            $id = $this->input->post('id');          
        }
        
        if ($data = $this->model->get($id)) {            
            $this->layout->view($this->_detail_view, $data);
        } else {
            redirect ('/');
        }
    }    
    
    // --------------------------------------------------------------------

    /**
     * Add a new entry.
     */
    function add() {
        $this->_prep_form_values();        

        if ($this->input->post('submit') || $this->input->is_ajax_request()) {            
            $id = $this->_save(null, $this->model);

            if ($id) {
                if ($this->input->is_ajax_request()) {
                    echo $id;
                    exit();
                }                                
            }
        }
    }    

    // --------------------------------------------------------------------

    /**
     * Delete.
     *
     * @param mixed $id ID.
     */
    function delete($id = null) {
        if ($this->input->post('id') || $id > 0) {
            if (is_null($id)) {
                $id = explode(',', $this->input->post('id'));
            }

            if ($this->model->delete($id)) {
                $message = 'Entry/s successfully deleted.';
                $response = 1;
            } else {
                $message = 'Could not delete the entry. Please contact the administrator.';
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
    
    // --------------------------------------------------------------------

    function jqgrid() {
        if ($this->input->is_ajax_request()) {
            if ($this->input->post('_search') == 'true') {
                $records = $this->model->search(
                        $this->input->post('searchField'), 
                        $this->input->post('searchString'),
                        $this->input->post('searchOper')
                        );
                
            } else {
                $records = $this->model->fetch_all();
            }
                        
            // Get total number of records for pagination and display purposes.
            $response->records = $records->num_rows();
            
            if ($response->records > 0) {
                $response->total = ceil($response->records / $this->input->post('rows'));
            } else {
                $response->total = 0;
            }
            
            $page = $this->input->post('page');
            
            if ($page > $response->total) {
                $page = $response->total;
            }
            
            $response->page = $page;
            $start = $this->input->post('rows') * $page - $this->input->post('rows');

            if ($start < 0) {
                $start = 0;
            }
            
            if ($this->input->post('_search') == 'true') {
                $results = $this->model->search(                        
                        $this->input->post('searchField'), 
                        $this->input->post('searchString'),
                        $this->input->post('searchOper'),
                        $this->input->post('rows'), 
                        $start, 
                        $this->input->post('sidx'), 
                        $this->input->post('sord')                        
                        );
            } else {
                $results = $this->model->fetch_all(
                        $this->input->post('rows'), 
                        $start, 
                        $this->input->post('sidx'), 
                        $this->input->post('sord')
                        );
            }            

            $i = 0;
            foreach ($results->result_array() as $result) {
                $cell = array();
                $response->rows[$i]['id'] = $result[$this->model->get_primary_key()];
                foreach ($result as $key => $column) {
                    if ($key == 'use_default_markup') {
                        $column = ($column == 1) ? 'Yes' : 'No';
                    }
                    $response->rows[$i][$key] = $column;
                }
                
                $i++;
            }
            
            $data['json'] = $response;

            $this->load->view('json', $data);
        }
    }
    
    // --------------------------------------------------------------------

    public function form($id = null) {
        $this->set_current_action('add');
                
        if (!is_null($id) && $record = $this->model->get($id)) {            
            $this->_prep_form_values(null, $record);
            $this->view_data['record_id'] = $id;
        } else {
            $this->_prep_form_values(null);
        }
        
        if ($this->input->post($this->model->get_primary_key()) || $this->input->is_ajax_request())
        {
            if ($this->input->post($this->model->get_primary_key()) > 0) {
                $this->_form_data[$this->model->get_primary_key()] = $this->input->post($this->model->get_primary_key());                
            }
            
            $id = $this->_save(null, $this->model);
            
            if ($id)
            {
                if ($this->input->is_ajax_request())
                {
                    echo $id; exit();
                }

                $uri = $this->uri->segment_array();
                if (!isset($this->_form_data[$this->model->get_primary_key()])) {
                    $this->session->set_flashdata('message', 'Add success.');
                    unset($uri[count($uri)]);
                } else {
                    $c = count($uri);
                    unset($uri[$c]);
                    unset($uri[$c - 1]);
                    $this->session->set_flashdata('message', 'Update success.');                    
                }      
                
                redirect (implode('/', $uri));
            }
        }
                
        $this->layout->view($this->_form_view, $this->view_data);
    }    

    // --------------------------------------------------------------------

    function is_admin() {
        return ($this->user->group_id == 1);
    }	

    function export() {		
        $this->load->helper('csv');        

        $this->db->select(
            array(
                'order.control_number', 
                'order.items_description', 
                'CONCAT(client.firstname, " ", client.lastname) client', 
                'CONCAT(delivery.firstname, " ", delivery.lastname) send_to', 
                'delivery.city', 
                'CONCAT(delivery.street_number, " ", delivery.street, " ", delivery.subdivision, " ", delivery.city, " ", delivery.region) address', 
                'order.status'
                )
        );
        $this->db->join('order_address_client client', 'client.order_address_client_id = order.order_address_client_id', 'left');
        $this->db->join('order_address delivery', 'delivery.order_id = order.order_id', 'left');

        $this->db->from('order');

        echo query_to_csv($this->db->get(), TRUE, 'tecson.csv'); 
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */

