<?php

class cOrder extends cBase implements iModel
{
	public static function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('orders', '' ,true);        
        
        return $CI->orders;
	}

	public function getOrderItems()
	{
		if (!$this->inCache('items')) {
			$items = cOrderItem::getByOrderId($this->order_id);

			$this->setCache('items', $items);
		}

		return $this->getCache('items');
	}

	public function getBranch()
	{
		if (!$this->inCache('branch')) {
			$branch = new cBranch($this->branch_id);

			$this->setCache('branch', $branch);
		}

		return $this->getCache('branch');		
	}

    // --------------------------------------------------------------------

    public function completeOrder() {
        $itemCollection = $this->getOrderItems();
        // Check if there is enough.
        $errors = array();
        $items  = array();
        
        foreach ($itemCollection as $key => $item) {
            $inventory_item = cInventory::loadByItemBranch($item->item_id, $this->branch_id);

            if ($inventory_item && $inventory_item->quantity < $item->quantity) {
                $errors[] = $inventory_item->getItem()->name;
            } elseif (!$inventory_item) {
                $i = new cItem($item->item_id);
                $errors[] = $i->name;
            }

            $inventory_item->quantity -= $item->quantity;

            $items[] = $inventory_item;
        }

        if (count($errors) > 0) {
            throw new Exception('Not enough stock for the following: ' . implode(',', $errors));
        }

        foreach ($items as $item) {
        	$item->save();
        }

        $this->status = 'Complete';
        $this->date_completed = date('Y-m-d H:i:s', strtotime($this->date_completed));

        return $this->getModel()->do_update((array) $this);
    }	
}