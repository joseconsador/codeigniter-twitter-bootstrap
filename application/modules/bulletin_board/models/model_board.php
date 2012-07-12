<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "blog" table.
 *
 * @package Blog
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-08-03
 */
class Model_board extends MY_Model {

    private $_table_name = 'board';
    private $_primary_key = 'index';

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    // --------------------------------------------------------------------

    /**
     *
     * Override do_save to perform some module specific operations.
     *
     * @param array $params
     * @return mixed
     */
    function do_save($params)
    {
        if ($this->session->userdata('file_filename'))
        {
            $params['filename'] = $this->session->userdata('file_filename');
        }

        return parent::do_save($params);
    }

    // --------------------------------------------------------------------

    /**
     *
     * Override do_create to perform some module specific operations.
     *
     * @param array $params
     * @return mixed
     */
    function do_create($params)
    {
        if (isset($params['field_filename']))
        {
            unset ($params['field_filename']);
        }

        return parent::do_create($params);
    }

    // --------------------------------------------------------------------

    /**
     *
     * Override delete() to perform some module specific operations.
     *
     * @param mixed $id
     * @return mixed
     */
    function delete($id)
    {        
        $posts = $this->get($id);
        // Force $posts to be an array so we can delete multiple records at once.
        if (!is_array($posts))
        {
            $posts = array($posts);
        }

        if (parent::delete($id))
        {
            foreach ($posts as $post)
            {
                if (trim($post->filename) != ''
                      && file_exists(getcwd() . '/uploads/' . $post->filename)
                        )
                {
                    unlink (getcwd() . '/uploads/' . $post->filename);
                }
            }

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
     *
     * Override do_update to perform some module specific operations.
     *
     * @param array $params
     * @return mixed
     */
    function do_update($params)
    {
        if (trim($params['filename']) == '')
        {
            unset($params['filename']);
        }
        else
        {
            if (file_exists(getcwd() . '/uploads/' . $params['old_file']))
            {
                // Delete the old file.
                unlink(getcwd() . '/uploads/' . $params['old_file']);
            }            
        }

        if (isset($params['old_file']))
        {
            unset($params['old_file']);
        }

        return parent::do_update($params);
    }

    // --------------------------------------------------------------------

    /**
     * Get posts for a specific date.
     *
     * @param date $date
     *
     * @return obj
     */
    function get_posts_for_day($date)
    {
        $given = date('Y-m-d 23:59:59', strtotime($date));
        $past  = date('Y-m-d 00:00:00', strtotime($date));

        $this->db->where('registerTime >', $past);
        $this->db->where('registerTime <', $given);

        return $this->db->get($this->_table_name);
    }

    // --------------------------------------------------------------------

    /**
     * Just a wrapper fo get_posts_for_day.
     * Used to get the posts for this day.
     *
     * @return obj
     */
    function get_posts_today()
    {
        return $this->get_posts_for_day(date('Y-m-d'));
    }
}

/* End of file model_board.php */
/* Location: ./application/modules/message_board/models/model_board.php */
