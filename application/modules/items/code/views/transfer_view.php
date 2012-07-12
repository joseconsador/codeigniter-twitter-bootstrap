<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if ($this->user->is_admin && !$transfer->approved):?>
    <?php echo form_open('/items/inventory/transfers/approve')?>
    <?php echo form_hidden('inventory_transfer_id', $transfer->inventory_transfer_id);?>
    <p><input type="submit" name="submit" value="Approve"/></p>    
    <?php echo form_close()?>
<?php endif?>
<h3>Details</h3>
<div class="grid_16">
    <div class="grid_3">
        <p>
            <label>Control Number</label>
            <?= $transfer->code;?>
        </p>
    </div>
    <div class="grid_3">
        <p>
            <label>Branch From</label>
            <?= $transfer->getBranchFrom()->name;?>
        </p>
    </div>
    <div class="grid_3">
        <p>
            <label>Branch To</label>
            <?= $transfer->getBranchTo()->name;?>
    </div>
    <div class="grid_3">
        <p>
            <label>Staff</label>
            <?= $transfer->getStaff()->getFullName();?>
    </div>    
</div>

<h3>Transfer Out</h3>
<div class="grid_16">
    <table class="">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php $items = $transfer->getItems();?>
            <?php foreach($items as $item):?>
            <tr>
                <td><?=$item->getItem()->getItem()->name?></td>
                <td><?=$item->quantity?></td>
                <td><?=$item->price?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table> 
</div>

