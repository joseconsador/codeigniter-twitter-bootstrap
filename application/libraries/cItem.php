<?php

class cItem extends cBase implements iModel
{
	public static function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('items', '' ,true);        
        
        return $CI->items;
	}
}