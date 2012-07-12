<?php

class cUser extends cBase implements iModel
{
	public static function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('user_model', '' ,true);        
        
        return $CI->user_model;
	}

	public function getFullName()
	{
		return $this->firstname . ' ' . $this->lastname;
	}
}