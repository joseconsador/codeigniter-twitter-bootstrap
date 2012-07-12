<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<h3>Transfers</h3>

<div class="grid_16">
    <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-plus"></span>
    <?=anchor('items/inventory/transfers/form', 'Transfer Out');?>
</div>
<div class="grid_16">
    <?php if (isset($transfers) && count($transfers) > 0):?>
        <table class="">
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
                        <span class="clearfix" style="float: left;">
                            <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-pencil"></span>
                            <?=anchor('items/inventory/transfers/view/' . $transfer->inventory_transfer_id, 'View');?>
                        </span>                        
                        <span>
                            <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-cancel"></span>
                            <?=anchor('items/inventory/transfers/delete/' . $transfer->inventory_transfer_id, 'Delete', 'class="jqdelete"');?>
                        </span>                                                
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" class="pagination">
                        <?php echo $this->pagination->create_links(); ?>
                    </td>
                </tr>                
            </tfoot>
        </table>
        <div id="dialog-confirm" title="Delete this transfer?">
            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This item will be permanently deleted and cannot be recovered. Are you sure?</p>
        </div>    
    <?php endif;?>
</div>