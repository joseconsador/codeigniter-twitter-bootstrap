<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="<?=site_url('orders')?>">Orders</a> <span class="divider">/</span>
  </li>
  <li class="active">View</li>
</ul>

<div class="">
    <div class="span4">
        <h3>Details</h3>
        <dl>
            <dt>Order Control Number</dt>
                <dd><?= $control_number;?></dd>
            <dt>Branch</dt>
                <dd><?= $branch;?></dd>
            <dt>Staff</dt>
                <dd><?= $staff_firstname . ' ' . $staff_lastname;?></dd>
            <dt>Order Type</dt>
                <dd><?=$order_type_name?></dd>
        </dl>                
    </div>

    <div class="span4">
        <h3>Client Info</h3>
        <dl>
            <dt>First Name</dt>
                <dd><?=$client_address->firstname?></dd>
            <dt>Last Name</dt>
                <dd><?=$client_address->lastname?></dd>
            <dt>Cellphone</dt>
                <dd><?=$client_address->firstname?></dd>
            <dt>Telephone</dt>
                <dd><?=$client_address->telephone?></dd>
            <dt>Email</dt>
                <dd><?=$client_address->email?></dd>   
            <dt>Number</dt>
                <dd><?=$client_address->street_number?></dd>
        </dl>
    </div> 

    <div class="span4">
        <h3>Payment Details</h3>
        <dl>
            <dt>Mode of Payment</dt>
            <dd><?=$payment_type?><?php if ($payment_type_id == 2) echo '(' . $card_number . ')'?></dd>
        </dl>
        <table class="table">
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

    <div class="clearfix"></div>
    <hr>
    <div class="row-fluid">
        <h3>Order Info</h3>
        <div>
            <table id="item-list" class="table table-bordered table-striped">
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
        <div class="clearfix"></div>
        <?php if($order_type == 1):?>
        <div class="grid_16">    
            <div class="grid_5">
                <p>
                    <h4>Branch</h4>
                    <?=$order_pickup->branch?>
                </p>
            </div>
            <div class="grid_5">
                <p>
                    <h4>Date and Time</h4>
                    <?=$order_pickup->datetime?>
                </p>
            </div>
        </div>
        <?php endif;?>
        <!-- Delivery -->
        <?php if ($order_type == 2):?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date and Time</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Message</th>
                    <th>Contact</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo isset($order_delivery->delivery_datetime) ? $order_delivery->delivery_datetime : ''; ?></td>
                    <td>
                        <?php echo isset($order_delivery->firstname) ? $order_delivery->firstname : ''; ?>&nbsp;
                        <?php echo isset($order_delivery->lastname) ? $order_delivery->lastname : ''; ?>
                    </td>
                    <td>
                        <?php echo isset($order_delivery->address) ? $order_delivery->address : ''; ?>, 
                        <?php echo isset($order_delivery->city) ? $order_delivery->city : ''; ?>
                    </td>
                    <td><?php echo isset($order_delivery->message) ? $order_delivery->message : ''; ?></td>
                    <td><?php echo isset($order_delivery->cellphone) ? $order_delivery->cellphone : ''; ?></td>
                    <td><?php echo isset($order_delivery->email) ? $order_delivery->email : ''; ?></td>
                </tr>
            </tbody>
        </table>
        <?php endif;?>
        <!-- END Delivery -->
    </div>
</div>