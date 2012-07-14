<div class="control-group">
    <label class="control-label" for="order_cost">Items</label>
    <div class="controls">
		<select name="item-selection" data-placeholder="Select item...">
			<option value=""></option>
			<?php if(isset($items_selection)):?>
				<?php foreach ($items_selection as $item):?>
					<option value="<?=$item->item_inventory_id;?>"><?=$item->item_name?></option>
				<?php endforeach;?>
			<?php endif;?>
		</select>        
    </div>
</div>
<div class="clearfix"></div>
<?php $total = 0;?>
<div class="span10">	
	<table id="item-list" class="table table-striped">
		<thead>
			<tr>
				<th>Item</th>
				<th>Quantity</th>
				<th>Cost</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody></tbody>
		<tfoot>
		<?php if(isset($order_items) && count($order_items)):				
				if (!(is_array($order_items))) {
					$order_items = array($order_items);
				}
		?>
			<?php foreach($order_items as $order_item): ?>
			<tr id="<?php echo $order_item->item_id;?>">
				<td class="item-name">
					<?=$order_item->name?>
					<input type="hidden" id="item-<?=$order_item->item_id;?>" name="items[]" value="<?=$order_item->item_id?>" />
					<input type="hidden" id="qty-<?=$order_item->item_id?>" name="qty[]" value="<?=$order_item->quantity?>" />
					<input type="hidden" id="order_item-<?=$order_item->order_item_id;?>" name="order_item[]" value="<?=$order_item->order_item_id?>" />
				</td>
				<td><?=$order_item->quantity?></td>
				<td><?=$order_item->quantity * $order_item->unit_cost?></td>
				<td><a href="javascript:void(0)" class="item-remove">Remove</a></td>
			</tr>
			<?php 
				$total += $order_item->quantity * $order_item->unit_cost;
			endforeach;?>
		<?php endif;?>
			<tr>
				<td></td>
				<td>Subtotal</td>
				<td><span id="subtotal"><?php echo (isset($total)) ? $total : '';?></span></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td>Final Cost</td>
				<td>
					<span id="final-cost">
						<input type="text" name="final_cost" value="<?php echo (isset($final_cost)) ? $final_cost : $total;?>" />
						<small>(Leave blank to use subtotal)</small>
					</span>
				</td>
				<td></td>
			</tr>			
		</tfoot>
	</table>
</div>