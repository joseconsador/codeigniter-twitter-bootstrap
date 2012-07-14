        <div class="control-group">
            <label class="control-label" for="client[firstname]">First Name</label>
            <div class="controls">
                <input type="text" class="input-xlarge required" name="client[firstname]" id="client[firstname]" value="<?php echo isset($client_address->firstname) ? $client_address->firstname : '';?>" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="client[lastname]">Last Name</label>
            <div class="controls">
                <input type="text" class="input-xlarge required" name="client[lastname]" id="client[lastname]" value="<?php echo isset($client_address->lastname) ? $client_address->lastname : '';?>" />
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="client[cellphone]">Contact</label>
            <div class="controls">
                <input type="text" class="input-xlarge required" name="client[cellphone]" id="client[cellphone]" value="<?php echo isset($client_address->cellphone) ? $client_address->cellphone : '';?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="client[email]">Email</label>
            <div class="controls">
                <input type="text" class="input-xlarge required" name="client[email]" id="client[email]" value="<?php echo isset($client_address->email) ? $client_address->email : '';?>" />
            </div>
        </div>
<?php if(isset($order_address_client_id) && $order_address_client_id > 0):?>
<input type="hidden" name="order_address_client_id" value="<?php echo $order_address_client_id;?>" />
<?php endif;?>
