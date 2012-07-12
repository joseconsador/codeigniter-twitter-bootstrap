<div class="clearfix"></div>
<div class="grid_5">
	<p>
		<label>Items Description</label>
		<input type="text" name="items_description" class="required" value="<?php echo isset($items_description) ? $items_description : ''; ?>" />
	</p>
</div>
<div class="clearfix"></div>
<?php $this->load->view('item_list_modify');?>
<div class="clearfix"></div>
<div class="grid_5">
	<p>
		<label>Order Type:</label>
		<?= form_dropdown('order_type', create_dropdown('order_type', 'name'), isset($order_type) ? $order_type : '');?>
	</p>
</div>
<!-- Order type inputs -->
<div <?= ($order_type == 2) ? 'class="hidden"' : ''?> id="pickup-details">
	<div class="clearfix"></div>
	<div class="grid_5">
		<p>
			<label>Branch</label>
			<?= form_dropdown('pickup[branch_id]', create_dropdown('branches', 'name'), isset($order_pickup->branch_id) ? $order_pickup->branch_id : '') ?>	
		</p>
	</div>
	<div class="grid_5">
		<p>
			<label>Date and Time</label>
			<input type="text" name="pickup[datetime]" class="datetimepick" readonly value="<?= isset($order_pickup->datetime) ? date('m/d/Y h:i a', strtotime($order_pickup->datetime)) : '' ?>"/>
		</p>
	</div>
</div>	
<div <?= ($order_type == 1) ? 'class="hidden"' : ''?> id="delivery-details">			
	<div class="clearfix"></div>
	<div class="grid_5">
		<p>
			<label>Date and Time</label>
			<input type="text" name="delivery[delivery_datetime]" class="datetimepick" value="<?php echo isset($order_delivery->delivery_datetime) ? $order_delivery->delivery_datetime : ''; ?>" />
		</p>
	</div>
	<div class="grid_5">
		<p>
			<label>Message</label>
			<textarea name="delivery[message]"><?php echo isset($order_delivery->message) ? $order_delivery->message : ''; ?></textarea>
		</p>
	</div>
	<div class="clearfix"></div>
	<div class="grid_5">
		<p>
			<label>First Name</label>
			<input type="text" class="" name="delivery[firstname]" value="<?php echo isset($order_delivery->firstname) ? $order_delivery->firstname : ''; ?>" />
		</p>
	</div>
	<div class="grid_5">
		<p>
			<label>Last Name</label>
			<input type="text" class="" name="delivery[lastname]" value="<?php echo isset($order_delivery->lastname) ? $order_delivery->lastname : ''; ?>" />
		</p>
	</div>
	<div class="clearfix"></div>
	<div class="grid_5">
		<p>
			<label>Cellphone</label>
			<input type="text" class="" name="delivery[cellphone]" value="<?php echo isset($order_delivery->firstname) ? $order_delivery->firstname : ''; ?>" />
		</p>
	</div>
	<div class="grid_5">
		<p>
			<label>Telephone</label>
			<input type="text" class="" name="delivery[telephone]" value="<?php echo isset($order_delivery->telephone) ? $order_delivery->telephone : ''; ?>" />
		</p>
	</div>
	<div class="grid_6">
		<p>
			<label>Email</label>
			<input type="text" class="" name="delivery[email]" value="<?php echo isset($order_delivery->email) ? $order_delivery->email : ''; ?>" />
		</p>
	</div>
	<div class="clearfix"></div>
	<div class="grid_2">
		<p>
			<label>Number</label>
			<input type="text" class="" name="delivery[street_number]" value="<?php echo isset($order_delivery->street_number) ? $order_delivery->street_number : ''; ?>" />
		</p>
	</div>  
	<div class="grid_5">
		<p>
			<label>Street</label>
			<input type="text" class="" name="delivery[street]" value="<?php echo isset($order_delivery->street) ? $order_delivery->street : ''; ?>" />
		</p>
	</div>            
	<div class="grid_5">
		<p>
			<label>Subdivision</label>
			<input type="text" class="" name="delivery[subdivision]" value="<?php echo isset($order_delivery->subdivision) ? $order_delivery->subdivision : ''; ?>" />
		</p>
	</div>
	<div class="grid_5">
		<p>
			<label>City</label>
			<input type="text" class="" name="delivery[city]" value="<?php echo isset($order_delivery->city) ? $order_delivery->city : ''; ?>" />
		</p>
	</div>
	<div class="grid_5">
		<p>
			<label>Region/Province</label>
			<input type="text" class="" name="delivery[region]" value="<?php echo isset($order_delivery->region) ? $order_delivery->region : ''; ?>" />
		</p>
	</div>
	<div class="grid_2">
		<p>
			<label>Zip Code</label>
			<input type="text" class="" name="delivery[zip_code]" value="<?php echo isset($order_delivery->zip_code) ? $order_delivery->zip_code : ''; ?>" />
		</p>
	</div>          
	<div class="clearfix"></div>					
</div>
<!-- END Order type inputs -->