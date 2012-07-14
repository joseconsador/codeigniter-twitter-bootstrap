   <div class="control-group">
    <label class="control-label" for="order_cost">Mode of Payment</label>
    <div class="controls">
		<?php echo form_dropdown('payment_type_id', create_dropdown('payment_type', 'name'), isset($payment_type_id) ? $payment_type_id : '', 'class="required"');?>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="card_number">Card Number</label>
    <div class="controls">
		<input name="card_number" />
    </div>
</div>        