<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="<?=site_url('items/categories')?>">Categories</a> <span class="divider">/</span>
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
            <label class="control-label" for="name">Name</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required" name="name" id="name" value="<?php echo isset($name) ? $name : '';?>" />
                </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="markup">Markup</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required" name="markup" id="markup" value="<?php echo isset($markup) ? $markup : '';?>" />
                </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="use_default_markup">Use Default Markup</label>
                <div class="controls">
                    <?=form_dropdown('use_default_markup', array('No', 'Yes'), isset($use_default_markup) ? $use_default_markup : '', 'class="required"');?>
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
