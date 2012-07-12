<?php

class cOrder extends cBase implements iModel
{
	public static function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('orders', '' ,true);        
        
        return $CI->orders;
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

    // --------------------------------------------------------------------

    public function completeOrder() {
        $itemCollection = cOrderItem::getByOrderId($this->order_id);
        // Check if there is enough.
        $errors = array();
        $items  = array();
        
        foreach ($itemCollection as $key => $item) {
            $inventory_item = new cInventory($item->item_id);

            if ($inventory_item && $inventory_item->quantity < $item->quantity) {
                $errors[] = $inventory_item->getItem()->name;
            } elseif ($inventory_item && isset($inventory_item->item_inventory_id)) {
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