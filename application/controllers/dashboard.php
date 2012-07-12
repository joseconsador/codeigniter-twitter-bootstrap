<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
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