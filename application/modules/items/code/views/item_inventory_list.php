<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li class="active">Inventory</li>
</ul>

<div class="row-fluid">
    <div class="span-12">    
        <a class="btn btn-success" href="<?=current_url() . '/form'?>">
            <i class="icon-plus icon-white"></i> 
            Add
        </a>
        <a class="btn" href="#filters" data-toggle="collapse"><i class="icon-plus icon-black"></i> Filters</a>
    </div>
</div>


<div id="filters" class="collapse">    
    <div class="span-12">
        <form class="well form-inline require-validation">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="name">Item Name</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="name" id="name" value="<?php echo isset($name) ? $name : '';?>" />
                        </div>
                </div>  
                <div class="control-group">
                    <label class="control-label" for="branch_id">Branch</label>
                        <div class="controls">
                            <?=form_dropdown('branch_id', create_dropdown('branches', 'name'))?>
                        </div>
                </div>                       
                <div class="control-group">
                    <label class="control-label" for="qty_type">Quantity</label>
                        <div class="controls">
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
                            <input type="text" name="quantity" class="number" value="<?=set_value('quantity');?>" />                                
                        </div>
                </div>     
                <button type="submit" class="btn"><i class="icon-search icon-black"></i> Search</button>  
            </fieldset>    
            <input type="hidden" name="search" value="1" />        
        </form>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
    <?php if (isset($inventory) && count($inventory) > 0):?>
        <table class="table table-striped">
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
                        <a class="btn" href="<?=site_url('items/inventory/form/' . $item->item_inventory_id)?>">
                            <i class="icon-edit icon-black"></i> 
                            Edit
                        </a>                                             
                       <a class="btn btn-danger delete" href="<?=site_url('items/inventory/delete/' . $item->item_inventory_id)?>">
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