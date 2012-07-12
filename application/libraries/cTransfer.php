<?php

class cTransfer extends cBase implements iModel
{	
	private $_items = array();

	public static function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('model_transfers', '' ,true);        
        
        return $CI->model_transfers;		
	}

	public static function fetchAll()
	{
		return self::getModel()->fetch_all();
	}

	public function getBranchFrom()
	{
		return $this->_getBranch('from');
	}

	public function getBranchTo()
	{
		return $this->_getBranch('to');
	}

	public function getStaff()
	{
		if (!$this->inCache('created_by')) {			
			$staff = new cUser($this->created_by);

			$this->setCache('created_by', $staff);
		}

		return $this->getCache('created_by');		
	}

	public function addItem($item)
	{
		$this->_items[] = $item;
	}

	public function getItems()
	{
		if (!$this->inCache('items')) {			
			$this->setCache('items',$this->getItemsCollection()->getCollection());			
		}

		return $this->getCache('items');	
	}

	public function getItemsCollection()
	{
		if (!$this->inCache('itemscollection')) {			
			$model = new ModelFactory('inventory_transfer_item', 'inventory_transfer_item_id');
			$query = $model->get($this->inventory_transfer_id, 'inventory_transfer_id');

			if ($query) {
				$itemCollection = new tCollection('cInventoryTransferItem');
				if (!is_array($query)) {$query = array($query);}
				foreach ($query as $r) {
					$itemCollection->addToCollection($r->inventory_transfer_item_id);
				}

				$this->setCache('itemscollection',$itemCollection);
			}
		}

		return $this->getCache('itemscollection');	
	}	

	public function getStatus()
	{
		return ($this->approved) ? 'Complete' : 'Pending';
	}

	public function save()
	{
		$id = parent::save();

		$model = new ModelFactory('inventory_transfer_item', 'inventory_transfer_item_id');

		if ($id) {
			foreach ($this->_items as $item) {
				$item['inventory_transfer_id'] = $this->inventory_transfer_id;
				
				$model->do_save($item);
			}
		}

		return $id;
	}

	public function delete()
	{
		if ($this->approved == 1) {			
			return FALSE;
		} else {
			if ($this->getItemsCollection()->delete()) {
				return parent::delete();
			}
		}

		return FALSE;
	}

	private function _getBranch($type)
	{
		$t = 'branch_id_' . $type ;

		if (!$this->inCache($t)) {			
			$branch = new cBranch($this->$t);

			$this->setCache($t, $branch);
		}

		return $this->getCache($t);
	}

	public function approve()
	{
		if (!$this->approved) {
			$items = $this->getItems();
			$branchToInventory = new cBranchInventory($this->branch_id_to);

			foreach ($items as $transferItem) {
				$inventoryItem = $transferItem->getItem();
				// Subtract inventory from source.
				$inventoryItem->quantity -= $transferItem->quantity;				
				$inventoryItem->save();
				// Add transfer to destination.
				// Check if item is in destination's inventory.
				$CI =& get_instance();
				$CI->db->where('item_id', $inventoryItem->item_id);
				$CI->db->where('branch_id', $this->branch_id_to);

				if ($CI->db->get('item_inventory')->num_rows() == 0) {
					$params['quantity']   = $transferItem->quantity;
					$params['item_id']    = $inventoryItem->item_id;
					$params['branch_id']  = $this->branch_id_to;

					$i = new cInventory($params);

					$branchToInventory->addToCollection($i);				
				} else {
					$collection = $branchToInventory->getCollection();

					foreach ($collection as $key => $i) {
						if ($i->item_id == $inventoryItem->item_id) {
							$i->quantity += $transferItem->quantity;
						}
					}
				}
			}

			$branchToInventory->save();

			$this->approved = 1;
			$this->save();
		}
	}
}