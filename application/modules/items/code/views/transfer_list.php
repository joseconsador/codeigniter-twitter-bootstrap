<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li class="active">Transfers</li>
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
    <div class="span12">
    <?php if (isset($transfers) && count($transfers) > 0):?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Staff</th>
                    <th>Control</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($transfers as $transfer):?>
                <tr>
                    <td><?=$transfer->inventory_transfer_id?></td>
                    <td><?=$transfer->getBranchFrom()->name?></td>
                    <td><?=$transfer->getBranchTo()->name?></td>
                    <td><?=$transfer->getStaff()->getFullName()?></td>
                    <td><?=$transfer->code?></td>                    
                    <td><?=$transfer->getStatus()?>
                    <td>         
                        <a class="btn btn-info" href="<?=site_url('items/inventory/transfers/view/' . $transfer->inventory_transfer_id)?>">
                            <i class="icon-info-sign icon-white"></i> 
                            View
                        </a>                                   
                       <a class="btn btn-danger delete" href="<?=site_url('items/inventory/transfers/delete/' . $transfer->inventory_transfer_id)?>">
                            <i class="icon-trash icon-white"></i> 
                            Delete
                        </a>                                                         
                    </td>
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