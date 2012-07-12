<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<h3>Filter</h3>

<form id="search-form" method="get" action="">
    <div class="grid_3">
        <p>
            <label>Item</label>
            <input type="text" name="item_name" value="<?=set_value('item_name');?>" />                    
        </p>    
    </div>
    <div class="grid_3">
        <p>
            <label>Branch</label>
            <?=form_dropdown('branch_id', create_dropdown('branches', 'name'))?>
        </p>
    </div>
    <div class="grid_4">
        <p>
            <label>Quantity</label>       
            <?=form_dropdown('qty_type', array(
                    'eq'  => 'Equal to', 
                    'gt'  => 'Greater than', 
                    'gte' => 'Greater than or equal to',
                    'lt'  => 'Less than',
                    'lte' => 'Less than or equal to'
                    ),
                    set_value('qty_type')
                );
                ?>
        </p>
    </div>
    <div class="grid_1">
        <p>
            <label>&nbsp;</label>
            <input type="text" name="quantity" value="<?=set_value('quantity');?>" />
        </p>
    </div>
    <div class="clear"></div>
    <input type="submit" value="Search" />
    <input type="hidden" name="search" value="1" />        
</form>

<h3>Inventory</h3>

<div class="grid_16">
    <?php if (isset($inventory) && count($inventory) > 0):?>
        <table class="">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item</th>
                    <th>Branch</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($inventory as $item):?>
                <tr>
                    <td><?=$item->item_inventory_id?></td>
                    <td><?=$item->item_name?></td>
                    <td><?=$item->branch_name?></td>
                    <td><?=$item->quantity?></td>                                                            
                    <td>
                        <span class="clearfix" style="float: left;">
                            <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-pencil"></span>
                            <?=anchor('items/inventory/form/' . $item->item_inventory_id, 'Edit');?>
                        </span>                        
                        <span>
                            <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-cancel"></span>
                            <?=anchor('items/inventory/delete/' . $item->item_inventory_id, 'Delete', 'class="jqdelete"');?>
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
        <div id="dialog-confirm" title="Delete this item?">
            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This item will be permanently deleted and cannot be recovered. Are you sure?</p>
        </div>    
    <?php endif;?>
</div>