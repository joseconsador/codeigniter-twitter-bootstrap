<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends MY_Controller{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('download');
	}

	function index($file = null)
	{ 		
		if(!is_null($file))
		{
			$filePath = str_replace('system/','',BASEPATH).'uploads/'.$file;

			force_download($file, file_get_contents($filePath));
			return TRUE;
		}
		return FALSE;
	}
	

}


/* End of file download.php */
/* Location: ./application/controllers/default/download.php */
