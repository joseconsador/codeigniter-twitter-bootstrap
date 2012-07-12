<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li class="active">Purchasing</li>
</ul>

<div class="row-fluid">
    <div class="span-12">    
        <a class="btn btn-success" href="<?=current_url() . '/form'?>">
            <i class="icon-plus icon-white"></i> 
            Add
        </a>
    </div>
</div>

<div class="row-fluid">
    <div class="span-12">
    <?php if (isset($purchases) && count($purchases) > 0):?>
        <table class="table table-striped">
            <thead>
                <tr>                    
                    <th>Supplier</th>
                    <th>Item</th>                    
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($purchases as $purchase):?>
                <tr>                    
                    <td><?=($purchase->getSupplier()) ? $purchase->getSupplier()->name : 'deleted'?></td>
                    <td><?=$purchase->getItem()->name?></td>
                    <td><?=$purchase->quantity?></td>
                    <td><?=$purchase->unit_price?></td>
                    <td><?=$purchase->getTotalCost()?></td>
                    <td><?=$purchase->getDateCreated();?>
                </tr>
                <?php endforeach;?>
            </tbody>
            <tfoot>              
            </tfoot>
        </table>
        <?php echo $this->pagination->create_links(); ?>
    <?php endif;?>
    </div>
</div>