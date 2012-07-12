<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<h3>Filter</h3>
<form id="search-form" method="get" action="">
    <div class="grid_3">
        <p>
            <label>Staff</label>
            <?=form_dropdown('created_by', create_dropdown('user_model', 'firstname,lastname'))?>
        </p>
    </div>
    <div class="grid_4">
        <p>
            <label>Branch</label>       
            <?=form_dropdown('branch_id', 
                    create_dropdown('branches', 'name'),
                    set_value('branch_id')
                );
                ?>
        </p>
    </div>
    <div class="clear"></div>
    <h3>Order By</h3>
    <div class="grid_3">
        <p>            
            Field: <?=form_dropdown('sort_by', $sort, set_value('sort_by'))?>
        </p>
    </div>
    <div class="grid_2">
        <p>            
            Direction: <?=form_dropdown('direction', array('desc' => 'Descending', 'asc' => 'Ascending'), set_value('direction'))?>
        </p>
    </div>    
    <div class="clear"></div>
    <input type="submit" value="Search" />
    <input type="hidden" name="search" value="1" />        
</form>

<h3>Spoilages</h3>

<div class="grid_16">
    <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-plus"></span>
    <?=anchor('items/inventory/spoilages/form', 'Add Spoilage');?>
</div>
<div class="grid_16">
    <?php if (isset($spoilages) && count($spoilages) > 0):?>
        <table class="">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Branch</th>
                    <th>Item</th>
                    <th>Staff</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($spoilages as $spoilage):?>
                <tr>
                    <td><?=$spoilage->item_inventory_spoilage_id?></td>
                    <td><?=$spoilage->getBranch()->name?></td>
                    <td><?=$spoilage->getItem()->getItem()->name?></td>
                    <td><?=$spoilage->getStaff()->getFullName()?></td>
                    <td><?=$spoilage->quantity?></td>
                    <td><?=$spoilage->amount?></td>
                    <td><?=$spoilage->getDateCreated();?>
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