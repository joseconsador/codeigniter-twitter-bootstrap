<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "branches" table.
 *
 * @package Branches
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-11-19
 */
class Branches extends MY_Model {

    private $_table_name = 'branches';
    private $_primary_key = 'branch_id';

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }    
}