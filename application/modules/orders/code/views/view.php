<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h3>Details</h3>
<div class="grid_16">
    <div class="grid_5">
        <p>
            <label>Order Control Number</label>
            <?= $control_number;?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Branch</label>
            <?= $branch;?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Staff</label>
            <?= $staff_firstname . ' ' . $staff_lastname;?>
    </div>
</div>

<h3>Client Info</h3>
<div class="grid_16">
    <div class="grid_5">
        <p>
            <label>First Name</label>
            <?=$client_address->firstname?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Last Name</label>
            <?=$client_address->lastname?>
        </p>
    </div>    
</div>
<div class="grid_16">    
    <div class="grid_5">
        <p>
            <label>Cellphone</label>
            <?=$client_address->firstname?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Telephone</label>
            <?=$client_address->telephone?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Email</label>
            <?=$client_address->email?>
        </p>
    </div>
</div>    
<div class="grid_16">
    <div class="grid_2">
        <p>
            <label>Number</label>
            <?=$client_address->street_number?>
        </p>
    </div>  
    <div class="grid_5">
        <p>
            <label>Street</label>
            <?=$client_address->street?> 
        </p>
    </div>            
    <div class="grid_5">
        <p>
            <label>Subdivision</label>
            <?=$client_address->subdivision?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>City</label>
            <?=$client_address->city?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Region/Province</label>
            <?=$client_address->region?>
        </p>
    </div>
    <div class="grid_2">
        <p>
            <label>Zip Code</label>
            <?=$client_address->zip_code?>
        </p>
    </div>             
</div>

<h3>Order Info</h3>
<div class="grid_16">
    <table id="item-list">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Cost</th>                
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
        <?php if(isset($order_items) && count($order_items)):
                $total = 0;

                if (!is_array($order_items)) {
                    $order_items = array($order_items);
                }
        ?>
            <?php foreach($order_items as $order_item):?>
            <tr id="<?php echo $order_item->item_id;?>">
                <td class="item-name"><?=$order_item->getItem()->name?></td>
                <td><?=$order_item->quantity?></td>
                <td><?=$order_item->quantity * $order_item->unit_cost?></td>                
            </tr>
            <?php endforeach;?>
        <?php endif;?>
            <tr>
                <td></td>
                <td>Subtotal</td>
                <td><span id="subtotal"><?php echo (isset($subtotal)) ? $subtotal : '';?></span></td>                
            </tr>
            <tr>
                <td></td>
                <td>Final Cost</td>
                <td><span id="final-cost"><?php echo (isset($final_cost)) ? $final_cost : '';?></span></td>
            </tr>            
        </tfoot>
    </table>
</div>
<hr />
<div class="grid_16">
    <div class="grid_2">
        <p>
            <label>Order Type</label>
            <?=$order_type_name?>
        </p>
    </div>        
</div>
<?php if($order_type == 1):?>
<div class="grid_16">    
    <div class="grid_5">
        <p>
            <label>Branch</label>
            <?=$order_pickup->branch?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Date and Time</label>
            <?=$order_pickup->datetime?>
        </p>
    </div>
</div>
<?php endif;?>
<!-- Delivery -->
<?php if ($order_type == 2):?>
<div class="grid_16">
    <div class="clearfix"></div>
    <div class="grid_5">
        <p>
            <label>Date and Time</label>
            <?php echo isset($order_delivery->delivery_datetime) ? $order_delivery->delivery_datetime : ''; ?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Message</label>
            <?php echo isset($order_delivery->message) ? $order_delivery->message : ''; ?>
        </p>
    </div>
    <div class="clearfix"></div>
    <div class="grid_5">
        <p>
            <label>First Name</label>
            <?php echo isset($order_delivery->firstname) ? $order_delivery->firstname : ''; ?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Last Name</label>
            <?php echo isset($order_delivery->lastname) ? $order_delivery->lastname : ''; ?>
        </p>
    </div>
    <div class="clearfix"></div>
    <div class="grid_5">
        <p>
            <label>Cellphone</label>
            <?php echo isset($order_delivery->firstname) ? $order_delivery->firstname : ''; ?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Telephone</label>
            <?php echo isset($order_delivery->telephone) ? $order_delivery->telephone : ''; ?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Email</label>
            <?php echo isset($order_delivery->email) ? $order_delivery->email : ''; ?>
        </p>
    </div>
    <div class="clearfix"></div>
    <div class="grid_2">
        <p>
            <label>Number</label>
            <?php echo isset($order_delivery->street_number) ? $order_delivery->street_number : ''; ?>
        </p>
    </div>  
    <div class="grid_5">
        <p>
            <label>Street</label>
            <?php echo isset($order_delivery->street) ? $order_delivery->street : ''; ?>
        </p>
    </div>            
    <div class="grid_5">
        <p>
            <label>Subdivision</label>
            <?php echo isset($order_delivery->subdivision) ? $order_delivery->subdivision : ''; ?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>City</label>
            <?php echo isset($order_delivery->city) ? $order_delivery->city : ''; ?>
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Region/Province</label>
            <?php echo isset($order_delivery->region) ? $order_delivery->region : ''; ?>
        </p>
    </div>
    <div class="grid_2">
        <p>
            <label>Zip Code</label>
            <?php echo isset($order_delivery->zip_code) ? $order_delivery->zip_code : ''; ?>
        </p>
    </div>          
    <div class="clearfix"></div>                    
</div>
<?php endif;?>
<!-- END Delivery -->

<h3>Payment Details</h3>
<div class="grid_16">
    <table>
        <tr>
            <td><label>Order Cost:</label></td>
            <td><span id="order-cost"><?=$order_cost?></span></td>
        </tr>
        <tr>
            <td><label>Delivery Cost:</label></td>
            <td><span id="delivery-cost"><?=$delivery_cost?></span></td>
        </tr>
            <tr>
            <td><label>Special Request Cost:</label></td>
            <td><span id="special-cost"><?=$special_cost?></span></td>
        </tr>
        <tr>
            <td><label>Total:</label></td>
            <td><span id="grand-total"><?=$grand_total?></span></td>
        </tr>   
    </table>
</div>
<div class="grid_5">
    <p>
        <label>Mode of Payment</label>
        <?=$payment_type?>
    </p>
</div>