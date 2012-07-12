<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *	@author		Jose Mari Consador
 *	@version	1.0.0
 *	@date		2011-03-10
 */

class MY_Model extends CI_Model
{
    // The name of the table the model represents.
    private $_table;
    // The primary key of the table.
    private $_primary;

    public function __construct()
    {
        parent::__construct();
        // Load the database library, we can either set it here or in autoload.php
        $this->load->database();
    }

    // --------------------------------------------------------------------

    // For php4 instantiation.
    function MY_Model()
    {
        self::__construct();
    }

    // --------------------------------------------------------------------

    /**
     * Get table name being used.
     *
     * @return string
     */
    public function get_table_name()
    {
        return $this->_table;
    }

    // --------------------------------------------------------------------

    /**
     * Set the table that will be used in most of the queries for the subclassed model.
     *
     * @param string $table_name
     */
    public function set_table_name($table_name)
    {
        $this->_table = $table_name;
    }

    // --------------------------------------------------------------------

    public function get_primary_key()
    {
        return $this->_primary;
    }

    // --------------------------------------------------------------------

    public function set_primary_key($primary_key)
    {
        $this->_primary = $primary_key;
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Handle saving or creating of new database entries.
    *  @param $params array Data to be stored.
    *  @return int
    */
    function do_save($params)
    {
        $fields = $this->db->list_fields($this->get_table_name());
        
        // Save only fields on database, so we don't have to use unset($params[]) to often.
        $valid_fields = array_intersect($fields, array_keys($params));

        foreach ($valid_fields as $field) {
            $data[$field] = $params[$field];
        }
        
        $data['date_updated'] = date('Y-m-d h:i:s');
        $data['updated_by']   = $this->session->userdata('user_id');
        
        if (isset($data[$this->_primary]) && $this->get($data[$this->_primary]) != FALSE)
        {
            return $this->do_update($data);
        }
        else
        {
            $data['date_created'] = date('Y-m-d h:i:s');
            $data['created_by']   = $this->session->userdata('user_id');

            return $this->do_create($data);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Adds a new record.
     *
     * @param array $params
     * @return mixed
     */
    function do_create($params)
    {
        // $this->db->insert() creates a new record.
        if ($this->db->insert($this->_table, $params))
        {
            // Return the last inserted ID.
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }

    function get_fields()
    {
        return $this->db->list_fields($this->get_table_name());
    }

    // --------------------------------------------------------------------

    /**
     * Updates an existing record.
     *
     * @param array $params
     * @return int
     */
    function do_update($params)
    {
        $fields = $this->get_fields();
        $data = array();
        // Build the query based on the primary key value.
        foreach ($params as $key => $column) {
            if (in_array($key, $fields)) {
                $data[$key] = $column;
            }
        }

        $this->db->where($this->_primary, $params[$this->_primary]);
        $this->db->update($this->_table, $data);

        return $params[$this->_primary];
    }

    // --------------------------------------------------------------------

    /**
     * Update multiple rows.
     *
     * @param <type> $ids
     * @param <type> $params
     * @return <type>
     */
    function bulk_update($ids, $params)
    {
        if (!is_array($ids))
        {
            $ids = array($ids);
        }

        $this->db->where_in($this->_primary, $ids);

        return $this->db->update($this->_table, $params);
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Fetch a table row by primary key.
    *  @param $key mixed Value of index.
    *  @param $field string OPTIONAL
    *
    *  @return mixed
    */
    function get($key, $field = '')
    {
        if (!is_array($key))
        {
            $key = array ($key);
        }
        
        if ($field == '') {
            $field = $this->get_primary_key();
        }

        $this->db->where_in($this->_table . '.' . $field, $key);

        $obj = $this->db->get($this->_table);

        if ($obj->num_rows > 0)
        {
            if ($obj->num_rows == 1)
            {// row() returns an object which holds data from a single row.                
               return $obj->row();
            }
            else
            {
                $obj = $obj->result();
                return $obj;
            }
        } 
        else
        {
            return FALSE;
        }
    }

    // --------------------------------------------------------------------

    /**
    *
    *  Fetch all rows.
    *  @return obj
    */
    function fetch_all($limit = null, $offset = null, $sort = null, $order = 'desc')
    {
        if (is_null($sort)) {
            $this->db->order_by($this->_primary . ' ' . $order);
        } else {
            $this->db->order_by($sort . ' ' . $order);
        }                

        return $this->db->get($this->_table, $limit, $offset);
    }

    // --------------------------------------------------------------------

    /**
     * Search function.
     *
     * @param mixed $key The field name/s.
     * @param mixed $value Value
     * @param int $limit
     * @param int $offset
     */
    function search($key, $value, $type = 'eq', $limit = null, $offset = null, $sort = null, $order ='desc')
    {
        if (!is_array($key))
        {
            $key = array ($key);
        }

        foreach ($key as $field)
        {
            if (is_array($field)) {                
                if (isset($field['type']) && $field['type'] != '') {
                    $type = $field['type'];
                }

                if (isset($field['value'])) {
                    $value = $field['value'];
                }

                $field = $field['field'];
            }

            switch ($type) {
                case 'eq':
                    $this->db->where($field, $value);
                    break;
                case 'ne':
                    $this->db->where($field . ' !=', $value);
                    break;
                case 'bw':
                    $this->db->like($field, $value, 'before');
                    break;
                case 'ew':
                    $this->db->like($field, $value, 'after');
                    break;
                case 'bn':
                    $this->db->not_like($field, $value, 'before');
                    break;
                case 'en':
                    $this->db->not_like($field, $value, 'after');
                    break;
                case 'cn':
                    $this->db->like($field, $value);
                    break;
                case 'nc':
                    $this->db->not_like($field, $value);
                    break; 
                case 'gt': 
                    $this->db->where($field . ' >', $value);              
                    break;
                case 'lt': 
                    $this->db->where($field . ' <', $value);
                    break;
                case 'gte': 
                    $this->db->where($field . ' >=', $value);              
                    break;
                case 'lte': 
                    $this->db->where($field . ' <=', $value);              
                    break;                    
            }            
        }
        
        return $this->fetch_all($limit, $offset, $sort, $order);
    }

    function get_dropdown_array($field)
    {
        $records = $this->fetch_all();

        $values = array(''  => 'Select&hellip;');
        
        foreach ($records->result_array() as $record) {
            $values[$record[$this->get_primary_key()]] =  $record[$field];
        }
        
        return $values;    
    }

    // --------------------------------------------------------------------

    /**
     * Fulltext Search function. You MUST have an index specified and engine set to MyISAM.
     *
     * @param array $index The index name/s.
     * @param mixed $value Value
     * @param int $limit
     * @param int $offset
     * 
     * @return object
     */
    function fulltext_search($index, $key_value, $limit = null, $offset = null)
    {
        foreach ($index as $key => $value)
        {
            $this->db->or_where('MATCH (' . $value . ') AGAINST ("' . $key_value . '") > ', 0, FALSE);
        }

        return $this->db->get($this->_table, $limit, $offset);
    }

    // --------------------------------------------------------------------

    /**
     *
     * Delete single or multiple records.
     * @param mixed $key Array of key values for multiple and int for single.
     * @return boolean
     */
    function delete($key)
    {
        if (!is_array($key))
        {
            $key = array($key);
        }

        $this->db->where_in($this->_table . '.' . $this->_primary, $key);
        return $this->db->delete($this->_table);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Get previous record.
     * 
     * @param int $id Primary
     *
     * @return mixed FALSE if no record found.
     */        
    function get_previous($id)
    {
        $this->db->where($this->_primary . ' <', $id);
        $this->db->order_by($this->_primary, 'ASC');
        
        $id = $this->db->get($this->_table);
        
        if ($id->num_rows() > 0)
        {
            return $id->row();
        }
        else
        {
            return FALSE;
        }
    }

    // --------------------------------------------------------------------
    
    /**
     * Get next record.
     * 
     * @param int $id Primary
     *
     * @return mixed FALSE if no record found.
     */
    function get_next($id)
    {
        $this->db->where($this->_primary . ' >', $id);
        $this->db->order_by($this->_primary, 'DESC');
        
        $id = $this->db->get($this->_table);
        
        if ($id->num_rows() > 0)
        {
            return $id->row();
        }
        else
        {
            return FALSE;
        }    
    }    
    
    /**
     * Insert multiple records at once.
     *
     * @param $data Array or Object.
     *
     * @return mixed.
     */
     function insert_batch($data = null)
     {
        // Check if the parameters have been set correctly.
        if (is_null($data) || (!is_object($data) && !is_array($data)))
        {
            return FALSE;
        }
        
        if ($this->db->insert_batch($this->_table, $data))
        {
            // Return the last inserted ID.
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }        
     }
}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */
