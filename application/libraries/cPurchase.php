<?php

class cPurchase extends cBase implements iModel
{
	public static function getModel()
	{
        return new ModelFactory('item_purchasing', 'item_purchasing_id');
	}

	public function getItem()
	{
		if (!$this->inCache('item')) {			
			$this->setCache('item', new cItem($this->item_id));
		}

		return $this->getCache('item');
	}

	public function getSupplier()
	{
		if (!$this->inCache('supplier')) {			
			$model = new ModelFactory('suppliers', 'supplier_id');
			$this->setCache('supplier', $model->get($this->supplier_id));
		}

		return $this->getCache('supplier');
	}

	public function getStaff()
	{
		if (!$this->inCache('staff')) {			
			$this->setCache('staff', new cUser($this->created_by));
		}

		return $this->getCache('staff');			
	}

	public function getTotalCost()
	{
		return $this->quantity * $this->unit_price;
	}

	public function process()
	{	
		$o_inventory = new cInventory();
		$inventory_item = $o_inventory->loadByItemBranch($this->item_id, HEAD_OFFICE);
		
		if (!$inventory_item) {
			$o_inventory->loadArray($this);
			$o_inventory->branch_id = HEAD_OFFICE;
			$o_inventory->save();
		} else {
			$inventory_item->quantity += $this->quantity;
			$inventory_item->save();
		}
	}
}