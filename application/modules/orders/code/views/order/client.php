<div class="grid_5">
    <p>
        <label>First Name</label>
        <input type="text" class="required" name="client[firstname]" value="<?php echo isset($client_address->firstname) ? $client_address->firstname : ''; ?>" />
    </p>
</div>
<div class="grid_5">
    <p>
        <label>Last Name</label>
        <input type="text" class="required" name="client[lastname]" value="<?php echo isset($client_address->lastname) ? $client_address->lastname : ''; ?>" />
    </p>
</div>
<div class="clearfix"></div>
<div class="grid_5">
    <p>
        <label>Cellphone</label>
        <input type="text" class="" name="client[cellphone]" value="<?php echo isset($client_address->firstname) ? $client_address->firstname : ''; ?>" />
    </p>
</div>
<div class="grid_5">
    <p>
        <label>Telephone</label>
        <input type="text" class="" name="client[telephone]" value="<?php echo isset($client_address->telephone) ? $client_address->telephone : ''; ?>" />
    </p>
</div>
<div class="grid_6">
    <p>
        <label>Email</label>
        <input type="text" class="" name="client[email]" value="<?php echo isset($client_address->email) ? $client_address->email : ''; ?>" />
    </p>
</div>
<div class="clearfix"></div>
<div class="grid_2">
    <p>
        <label>Number</label>
        <input type="text" class="" name="client[street_number]" value="<?php echo isset($client_address->street_number) ? $client_address->street_number : ''; ?>" />
    </p>
</div>  
<div class="grid_5">
    <p>
        <label>Street</label>
        <input type="text" class="" name="client[street]" value="<?php echo isset($client_address->street) ? $client_address->street : ''; ?>" />
    </p>
</div>            
<div class="grid_5">
    <p>
        <label>Subdivision</label>
        <input type="text" class="" name="client[subdivision]" value="<?php echo isset($client_address->subdivision) ? $client_address->subdivision : ''; ?>" />
    </p>
</div>
<div class="grid_5">
    <p>
        <label>City</label>
        <input type="text" class="" name="client[city]" value="<?php echo isset($client_address->city) ? $client_address->city : ''; ?>" />
    </p>
</div>
<div class="grid_5">
    <p>
        <label>Region/Province</label>
        <input type="text" class="" name="client[region]" value="<?php echo isset($client_address->region) ? $client_address->region : ''; ?>" />
    </p>
</div>
<div class="grid_2">
    <p>
        <label>Zip Code</label>
        <input type="text" class="" name="client[zip_code]" value="<?php echo isset($client_address->zip_code) ? $client_address->zip_code : ''; ?>" />
    </p>
</div>          
<?php if(isset($order_address_client_id) && $order_address_client_id > 0):?>
<input type="hidden" name="order_address_client_id" value="<?php echo $order_address_client_id;?>" />
<?php endif;?>
<div class="clearfix"></div>			