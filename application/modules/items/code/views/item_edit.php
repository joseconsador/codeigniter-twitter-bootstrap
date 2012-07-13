<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="<?=site_url('items')?>">Items</a> <span class="divider">/</span>
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
            <label class="control-label" for="item_code">Item Code</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required" name="item_code" id="item_code" value="<?php echo isset($item_code) ? $item_code : '';?>" />
                </div>
        </div>          
        <div class="control-group">
            <label class="control-label" for="name">Item Name</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required" name="name" id="name" value="<?php echo isset($name) ? $name : '';?>" />
                </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="category_id">Category</label>
                <div class="controls">
                    <?php echo form_dropdown('category_id', category_dropdown(), isset($category_id) ? $category_id : '', 'class="required "');?>
                </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="description">Description</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required" name="description" id="description" value="<?php echo isset($description) ? $description : '';?>" />
                </div>
        </div> 
        <div class="control-group">
            <label class="control-label" for="initial_cost">Initial Cost</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required number" name="initial_cost" id="initial_cost" value="<?php echo isset($initial_cost) ? $initial_cost : '';?>" />
                </div>
        </div> 
        <div class="control-group">
            <label class="control-label" for="markup">Markup</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required number" name="markup" id="markup" value="<?php echo isset($markup) ? $markup : '';?>" />
                </div>
        </div> 
        <div class="control-group">
            <label class="control-label" for="use_default_markup">Use Default Markup</label>
                <div class="controls">
                    <?=form_dropdown('use_default_markup', array('No', 'Yes'), isset($use_default_markup) ? $use_default_markup : '', 'class="required "');?>
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

