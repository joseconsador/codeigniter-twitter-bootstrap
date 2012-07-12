<?php

class cBranchInventory extends tCollection implements iModel
{
	public static function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('model_inventory', '' ,true);        
        
        return $CI->model_inventory;		
	}

	public function __construct($branch_id)
	{
		$collection = $this->getModel()->get($branch_id, 'branch_id');

		if ($collection) {
			parent::__construct('cInventory', $collection);
		} else {
			parent::__construct('cInventory');
		}		
	}
}