<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

    function index()
    {
    	if ($this->user->is_admin) {
    		redirect('dashboard');
    	}

        redirect('orders');
    }   
}
