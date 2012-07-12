<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2>Item Form</h2>
<?php if(validation_errors()):?>
    <p class="error"><?=validation_errors()?></p>
<?php endif;?>
<form action="" method="post" class="require-validation" enctype="multipart/form-data">
    <div class="grid_5">
        <p>
            <label>Item</label>
            <?php echo form_dropdown('item_id', create_dropdown('items', 'name'), isset($item_id) ? $item_id : '', 'class="required "');?>
        </p>
    </div>
    <div class="grid_6">
        <p>
            <label>Branch</label>
            <?php echo form_dropdown('branch_id', create_dropdown('branches', 'name'), isset($branch_id) ? $branch_id : '', 'class="required "');?>            
        </p>
    </div>
    <div class="grid_5">
        <p>
            <label>Quantity</label>
            <input type="text" class="required number " name="quantity" value="<?php echo isset($quantity) ? $quantity : '';?>" />
        </p>
    </div>
    <div class="grid_16">
        <input type="reset" value="Reset"/>
        <input type="submit" name="submit" value="Submit"/>
    </div>        

    <?php if (!isset($record_id)) {$record_id = '-1';}?>
    <input type="hidden" name="<?=$this->model->get_primary_key()?>" value="<?=$record_id?>" />
</form>
