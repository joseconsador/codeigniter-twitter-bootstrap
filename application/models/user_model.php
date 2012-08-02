<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for interacting with the "user" table.
 *
 * @package Base
 * @author  Jose Consador
 * @version 1.0.0
 * @date    2011-11-19
 */
class User_model extends MY_Model {

    private $_table_name = 'user';
    private $_primary_key = 'user_id';

    // --------------------------------------------------------------------

    public function  __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    // --------------------------------------------------------------------

    function authenticate($username, $password) {
		$this->db->where('username', $username);
		$this->db->where('password', md5($this->config->item('encryption_key') . $password));
		$this->db->limit(1);

		$user = $this->db->get('user')->row();

		if ($user) {			
			$user = new cUser($user->user_id);

			$user->last_signed_in = date('Y-m-d H:i:s');
			$user->save();

			$this->session->set_userdata('logged_in', TRUE);
			$this->session->set_userdata('user_id', $user->user_id);			
			$this->session->set_userdata('x', $this->encrypt->encode($user->user_id . $this->input->ip_address()));
			
			return TRUE;
		} else {
			return FALSE;
		}    	
    }
}