<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->vars(array('dashboard_nav' => 'class="active"'));
	}
    // --------------------------------------------------------------------

    /**
     * This is the default action.
     *
     */
    function index()
    {    	
		$this->layout->view('dashboard');
    }        
}