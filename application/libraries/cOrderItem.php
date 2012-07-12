<?php

class cOrderItem extends cBase implements iModel
{
	public static function getModel()
	{
		$CI =& get_instance();
        $CI->load->model('order_item' ,true);        
        
        return $CI->order_item;
	}

	public function getItem()
	{
		if (!$this->inCache('item')) {
			$inventoryItem = new cInventory($this->item_id);

			$this->setCache('item', $inventoryItem->getItem());
		}

		return $this->getCache('item');
	}

	public static function getByOrderId($orderId)
	{   
		$collection = new tCollection('cOrderItem', self::getModel()->get_by_order_id($orderId));		

		return $collection->getCollection();
	}
}