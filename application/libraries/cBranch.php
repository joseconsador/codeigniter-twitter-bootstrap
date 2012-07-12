<?php

class cBranch extends cBase implements iModel
{
	public static function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('branches', '' ,true);        
        
        return $CI->branches;		
	}
}