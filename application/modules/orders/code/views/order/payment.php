<table>
	<tr>
		<td>Order Cost:</td>
		<td><input type="text" name="order_cost" readonly/></td>
	</tr>
	<tr>
		<td>Delivery Cost:</td>
		<td><span id="delivery-cost"><input type="text" name="delivery_cost" value="0"/></span></td>
	</tr>
		<tr>
		<td>Special Request Cost:</td>
		<td><span id="special-cost"></span><input type="text" name="special_cost" value="0"/></td>
	</tr>
	<tr>
		<td>Total:</td>
		<td><span id="grand-total"><?php echo isset($grand_total) ? $grand_total : ''?></span></td>
	</tr>	
</table>

<div class="grid_5">
	<p>
		Mode of Payment
		<?php echo form_dropdown('payment_type_id', create_dropdown('payment_type', 'name'), isset($payment_type_id) ? $payment_type_id : '', 'class="required"');?>
	</p>
	<p>Card Number<input name="card_number" /></p>
</div>