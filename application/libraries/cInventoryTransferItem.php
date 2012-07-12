<?php

class cInventoryTransferItem extends cBase implements iModel
{
	public static function getModel()
	{        
        return new ModelFactory('inventory_transfer_item', 'inventory_transfer_item_id'); 
	}

	public function getItem()
	{
		if (!$this->inCache('item')) {			
			$item = new cInventory($this->item_inventory_id);

			$this->setCache('item', $item);
		}

		return $this->getCache('item');
	}
}