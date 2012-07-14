<?php

class cInventory extends cBase implements iModel
{
	public static function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('model_inventory', '' ,true);        
        
        return $CI->model_inventory;		
	}

	public static function loadByItemBranch($itemId, $branchId)
	{		
		$CI =& get_instance();
		$CI->db->where('branch_id', $branchId);
		$CI->db->where('item_id', $itemId);

		$item = $CI->db->get(self::getModel()->get_table_name());

		if ($item->num_rows() > 0) {
			return new cInventory($item->row());
		} 

		return FALSE;
	}

	public function getItem()
	{
		if (!$this->inCache('item')) {
			$item = new cItem($this->item_id);

			$this->setCache('item', $item);
		}

		return $this->getCache('item');
	}

	public function getBranch()
	{
		if (!$this->inCache('branch')) {
			$branch = new cBranch($this->branch_id);

			$this->setCache('branch', $branch);
		}

		return $this->getCache('branch');		
	}

	public static function getLowInventory($limit = 5) 
	{
		$CI =& get_instance();
		$CI->db->order_by('quantity', 'asc');
		$CI->db->limit($limit);

		$result = $CI->db->get(self::getModel()->get_table_name());

		if ($result->num_rows() > 0) {
			return new tCollection('cInventory', $result->result());
		} 

		return NULL;
	}
}