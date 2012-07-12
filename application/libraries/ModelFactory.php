<?php

class ModelFactory extends MY_Model
{
	// --------------------------------------------------------------------
	
    public function __construct($tableName, $primaryKey) {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($tableName);
        $this->set_primary_key($primaryKey);        
    }
}