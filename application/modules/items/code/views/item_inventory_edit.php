<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="<?=site_url('items/inventory')?>">Inventory</a> <span class="divider">/</span>
  </li>
  <li class="active">Add/Edit</li>
</ul>

<?php if(validation_errors()):?>
    <div class="alert">
        <button class="close" data-dismiss="alert">×</button>      
        <span class="label label-important">Error !</span>
        <?=validation_errors()?>
    </div>
<?php endif;?>

<div class="row-fluid">
    <form action="" method="post" class="form-horizontal well require-validation">
        <div class="control-group">
            <label class="control-label" for="item_id">Item</label>
                <div class="controls">
                    <?php echo form_dropdown('item_id', create_dropdown('items', 'name'), isset($item_id) ? $item_id : '', 'class="required "');?>
                </div>
        </div>                  
        <div class="control-group">            
            <label class="control-label" for="item_id">Branch</label>
            <div class="controls">
                <?php echo form_dropdown('branch_id', create_dropdown('branches', 'name'), isset($branch_id) ? $branch_id : '', 'class="required "');?>
            </div>
        </div>
        <div class="control-group">            
            <label class="control-label" for="item_id">Quantity</label>
            <div class="controls">
                <input type="text" class="required number " name="quantity" value="<?php echo isset($quantity) ? $quantity : '';?>" />
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <input type="button" onclick="history.go(-1)" class="btn" value="Cancel"/>
            </div>
        </div>          

        <?php if (!isset($record_id)) {$record_id = '-1';}?>
        <input type="hidden" name="<?=$this->model->get_primary_key()?>" value="<?=$record_id?>" />
    </form>
</div>
