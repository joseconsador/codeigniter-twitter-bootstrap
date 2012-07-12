<?php

class cSpoilage extends cBase implements iModel
{
	public static function getModel()
	{
        return new ModelFactory('item_inventory_spoilage', 'item_inventory_spoilage_id');
	}

	public function getItem()
	{
		if (!$this->inCache('item')) {			
			$this->setCache('item', new cInventory($this->item_inventory_id));
		}

		return $this->getCache('item');
	}

	public function getBranch()
	{
		if (!$this->inCache('branch')) {
			$item = $this->getItem();			

			$this->setCache('branch', $item->getBranch());
		}

		return $this->getCache('branch');		
	}

	public function getStaff()
	{
		if (!$this->inCache('staff')) {			
			$this->setCache('staff', new cUser($this->created_by));
		}

		return $this->getCache('staff');			
	}

	public function process()
	{		
		$spoilage = $this->getItem();
		$spoilage->quantity -= $this->quantity;
		return $spoilage->save();
	}
}