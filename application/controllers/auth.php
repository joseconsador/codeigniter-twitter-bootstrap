<?php 

class Auth extends MY_Controller 
{
	function __construct() {
		parent::__construct();		
	}

	function login() {
		$data = array();

		if ($this->input->post('username')) {
			$this->load->model('user_model');
			
			if ($this->user_model->authenticate($this->input->post('username'), $this->input->post('password'))) {
				redirect('dashboard');
			} else {
				$data['error'] = 'Your login credentials are incorrect.';	
			}
		} 
		
		$this->load->view('login', $data);
	}

	function logout() {
		$this->session->sess_destroy();

		redirect('auth/login');
	}
}