<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "user" table.
 *
 * @package Staff
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-11-19
 */
class Users extends MY_Model {

    private $_table_name = 'user';
    private $_primary_key = 'user_id';

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);                
    }
    
    public function do_save($params) {
        if ($params['password'] != '******') {
            $params['password'] = md5($this->config->item('encryption_key') . $params['password']);
        } else {
            unset($params['password']);
        }
        
        return parent::do_save($params);
    }
}