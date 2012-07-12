<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Default controller for Bulletin Board module.
 *
 * @package Bulletin Board
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-08-03
 */
class Post extends MY_Controller {

    // --------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_board', 'posts');
        $this->load->config('bbc');
    }

    // --------------------------------------------------------------------

    /**
     * This is the default action, lists all posts.
     *
     * @param int $page 
     */
    function index($page = 0)
    {
        // Check if a call to delete is present.
        if ($this->input->post('submit') && $this->input->post('index'))
        {
            $this->delete(); // exit.
        }

        $this->view_data['page_title'] = 'Board List';
        
        $posts = $this->posts->fetch_all();
        // Get total number of records for pagination and display purposes.
        $total = $posts->num_rows();

        if ($total > 0)
        {
            // Assign the value of $total to our view.
            $pagination['total_rows'] = $this->view_data['total'] = $total;
            $pagination['per_page']   = 10;
            $pagination['base_url']   = site_url('bbc/index/');
            $this->paginate($pagination);

            $results = $this->posts->fetch_all($pagination['per_page'], $page);

            $this->view_data['posts'] = $results->result();

            $this->view_data['today'] = $this->posts->get_posts_today()->num_rows();
            
        }

        $this->layout->view('list', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Add a new post entry.
     */
    function add()
    {
        $this->_prep_form_values('validation_bbc_post');

        $this->view_data['page_title'] = 'Board Write';

        if ($this->input->post('submit') || $this->input->is_ajax_request())
        {
            $id = $this->_save('validation_bbc_post', $this->posts);
            
            if ($id)
            {
                if ($this->input->is_ajax_request())
                {
                    echo $id; exit();
                }

                $this->session->set_flashdata('message', 'Post added.');

                redirect ('/');
            }
        }

        $this->layout->view('edit', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * View a post entry.
     *
     * @param int $id
     */
    function view($id = null)
    {
        $this->view_data['page_title'] = 'Board View';

        if (is_null($id) || ! $post = $this->posts->get($id))
        {
            show_error('Invalid or no ID specified');
        }

        // Merge the post data, by typecasting it as an array since it's an object.
        $this->view_data = array_merge($this->view_data, (array) $post);

        $this->layout->view('view', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
     * Edit a post entry.
     *
     * @param int $id
     *
     */
    function edit($id = null)
    {
        $this->view_data['page_title'] = 'Board Modify';
        
        if (is_null($id) || ! $post = $this->posts->get($id))
        {
            show_error('Invalid or no ID specified');
        }

        $this->_prep_form_values('validation_bbc_post', $post);       

        $this->view_data['index'] = $this->_form_data['index'] = $post->index;

        if ($post->filename != '')
        {
            $this->view_data['old_file'] = $this->_form_data['old_file'] = $post->filename;
        }

        if ($this->input->post('submit') || $this->input->is_ajax_request())
        {
            $id = $this->_save('validation_bbc_post', $this->posts);

            if ($id)
            {
                if ($this->input->is_ajax_request())
                {
                    echo $id; exit();
                }

                $this->session->set_flashdata('message', 'Post updated.');

                redirect (current_url());
            }
        }

        $this->layout->view('edit', $this->view_data);
    }

    // --------------------------------------------------------------------

    /**
    * Delete.
    *
    * @param mixed $id ID.
    */
    function delete($id = null)
    {
        if ($this->input->post('index') || $id > 0)
        {
            if (is_null($id))
            {
                $id = $this->input->post('index');
            }

            if ($this->posts->delete($id))
            {
                $message = 'Post/s successfully deleted.';
                $response = 1;
            }
            else
            {
                $message = 'Could not delete the entry. Please contact the administrator.';
                $response = 0;
            }

            if ($this->input->is_ajax_request())
            {
                echo json_encode(array('message' => $message, 'response' => $response)); exit();
            }
            else
            {
                $this->session->set_flashdata('message', $message);                
            }
        }

        redirect ('/');
    }

    // --------------------------------------------------------------------

    function search($page = 0)
    {
        // Check if a call to delete is present.
        if ($this->input->post('submit') && $this->input->post('index'))
        {
            $this->delete(); // exit.
        }

        $this->view_data['page_title'] = 'Board List';

        $posts = $this->posts->search($_GET['key'], $_GET['value']);
        // Get total number of records for pagination and display purposes.
        $total = $this->posts->fetch_all()->num_rows();

        if ($total > 0)
        {
            // Assign the value of $total to our view.
            $pagination['total_rows'] = $this->view_data['total'] = $total;
            $pagination['per_page']   = 10;
            $pagination['base_url']   = site_url('bbc/search/');
            $this->paginate($pagination);

            $results = $this->posts->search($_GET['key'], $_GET['value'], $pagination['per_page'], $page);

            $this->view_data['posts'] = $results->result();
            $this->view_data['today'] = $this->posts->get_posts_today()->num_rows();
        }

        $this->layout->view('list', $this->view_data);
    }
}


/* End of file Post.php */
/* Location: ./application/modules/bulletin_board/cv/controllers/Post.php */