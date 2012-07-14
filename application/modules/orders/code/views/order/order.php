<div class="control-group">
    <label class="control-label" for="order_cost">Items Description</label>
    <div class="controls">
        <input type="text" name="items_description" class="required" value="<?php echo isset($items_description) ? $items_description : ''; ?>" />
    </div>
</div>
<div class="clearfix"></div>

<div class="control-group">
    <label class="control-label" for="order_cost">Items</label>
    <div class="controls">
		<select name="item-selection" data-placeholder="Select item...">
			<option value=""></option>
			<?php if(isset($items_selection)):?>
				<?php foreach ($items_selection as $item):?>
					<option value="<?=$item->item_id;?>"><?=$item->name?></option>
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

<div class="clearfix"></div>

<div class="control-group">
    <label class="control-label" for="order_cost">Order Cost</label>
    <div class="controls">
        <input type="text" class="input-xlarge required" name="order_cost" id="order_cost" readonly />
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="deliverty_cost">Delivery Cost</label>
    <div class="controls">
        <span id="delivery-cost"><input type="text" name="delivery_cost" value="0"/></span>
    </div>
</div>        
<div class="control-group">
    <label class="control-label" for="special_cost">Special Request Cost</label>
    <div class="controls">
        <span id="special-cost"></span><input type="text" name="special_cost" value="0"/>
    </div>
</div>         
<div class="control-group">
    <label class="control-label" for="grand-total">Total</label>
    <div class="controls">
        <span id="grand-total"><?php echo isset($grand_total) ? $grand_total : ''?></span>
    </div>
</div>    
<div class="control-group">
    <label class="control-label" for="order_type">Order Type</label>
    <div class="controls">        
		<?= form_dropdown('order_type', create_dropdown('order_type', 'name'), isset($order_type) ? $order_type : '');?>
    </div>
</div>	
<!-- Order type inputs -->
<div class="hidden" id="pickup-details">
	<div class="control-group">
	    <label class="control-label" for="pickup[branch_id]">Branch</label>
	    <div class="controls">        			
			<?= form_dropdown('pickup[branch_id]', create_dropdown('branches', 'name'), isset($order_pickup->branch_id) ? $order_pickup->branch_id : '') ?>	
	    </div>
	</div>	
	<div class="control-group">
	    <label class="control-label" for="pickup[datetime]">Date and Time</label>
	    <div class="controls">        			
			<input type="text" name="pickup[datetime]" class="datetimepick" readonly value="<?= isset($order_pickup->datetime) ? date('m/d/Y h:i a', strtotime($order_pickup->datetime)) : '' ?>"/>
	    </div>
	</div>		
</div>	
<div class="hidden" id="delivery-details">	
	<div class="span5">		
		<div class="control-group">
		    <label class="control-label" for="delivery[delivery_datetime]">Date and Time</label>
		    <div class="controls">        
				<input type="text" name="delivery[delivery_datetime]" class="datetimepick" value="<?php echo isset($order_delivery->delivery_datetime) ? $order_delivery->delivery_datetime : ''; ?>" />			
		    </div>
		</div>		
		<div class="control-group">
		    <label class="control-label" for="deliver[message]">Message</label>
		    <div class="controls">        
				<textarea name="delivery[message]"><?php echo isset($order_delivery->message) ? $order_delivery->message : ''; ?></textarea>
		    </div>
		</div>	
		<div class="control-group">
		    <label class="control-label" for="deliver[firstname]">First Name</label>
		    <div class="controls">        
				<input type="text" class="" name="delivery[firstname]" value="<?php echo isset($order_delivery->firstname) ? $order_delivery->firstname : ''; ?>" />			
		    </div>
		</div>	
		<div class="control-group">
		    <label class="control-label" for="deliver[lastname]">Last Name</label>
		    <div class="controls">        			
				<input type="text" class="" name="delivery[lastname]" value="<?php echo isset($order_delivery->lastname) ? $order_delivery->lastname : ''; ?>" />
		    </div>
		</div>	
	</div>
	<div class="span5">
		<div class="control-group">
		    <label class="control-label" for="deliver[cellphone]">Cellphone</label>
		    <div class="controls">        
				<input type="text" class="" name="delivery[cellphone]" value="<?php echo isset($order_delivery->firstname) ? $order_delivery->firstname : ''; ?>" />			
		    </div>
		</div>	
		<div class="control-group">
		    <label class="control-label" for="deliver[telephone]">Telephone</label>
		    <div class="controls">        			
				<input type="text" class="" name="delivery[telephone]" value="<?php echo isset($order_delivery->telephone) ? $order_delivery->telephone : ''; ?>" />
		    </div>
		</div>		
		<div class="control-group">
		    <label class="control-label" for="deliver[email]">Email</label>
		    <div class="controls">        			
				<input type="text" class="" name="delivery[email]" value="<?php echo isset($order_delivery->email) ? $order_delivery->email : ''; ?>" />
		    </div>
		</div>		
		<div class="control-group">
		    <label class="control-label" for="deliver[address]">Address</label>
		    <div class="controls">        
				<input type="text" class="" name="delivery[address]" value="<?php echo isset($order_delivery->address) ? $order_delivery->address : ''; ?>" />			
		    </div>
		</div>		
		<div class="control-group">
		    <label class="control-label" for="deliver[city]">City</label>
		    <div class="controls">        			
				<input type="text" class="" name="delivery[city]" value="<?php echo isset($order_delivery->city) ? $order_delivery->city : ''; ?>" />
		    </div>
		</div>	
	</div>
</div>
<!-- END Order type inputs -->