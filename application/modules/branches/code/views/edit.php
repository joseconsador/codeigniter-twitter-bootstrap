<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="<?=site_url('items/branches')?>">Branches</a> <span class="divider">/</span>
  </li>
  <li class="active">Add/Edit</li>
</ul>

<?php if(validation_errors()):?>
    <div class="row-fluid">
        <span class="label label-important"><?=validation_errors()?></span>
    </div>
<?php endif;?>

<div class="row-fluid">
    <form action="" method="post" class="form-horizontal well require-validation">   
        <div class="control-group">
            <label class="control-label" for="branch_code">Branch Code</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required" name="branch_code" id="branch_code" value="<?php echo isset($branch_code) ? $branch_code : '';?>" />
                </div>
        </div>          
        <div class="control-group">
            <label class="control-label" for="name">Name</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required" name="name" id="name" value="<?php echo isset($name) ? $name : '';?>" />
                </div>
        </div>  
        <div class="control-group">
            <label class="control-label" for="location">Location</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required" name="location" id="location" value="<?php echo isset($location) ? $location : '';?>" />
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
