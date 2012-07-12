<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="<?=site_url('staff')?>">Staff</a> <span class="divider">/</span>
  </li>
  <li class="active">Add/Edit</li>
</ul>

<div class="row-fluid">
    <form action="" method="post" class="well form-horizontal require-validation">    
        <div class="control-group">
            <label class="control-label" for="firstname">First Name</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required" name="firstname" id="firstname" value="<?php echo isset($firstname) ? $firstname : '';?>" />
                </div>
        </div>   
        <div class="control-group">
            <label class="control-label" for="lastname">Last Name</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required" name="lastname" id="lastname" value="<?php echo isset($lastname) ? $lastname : '';?>" />
                </div>
        </div> 
        <div class="control-group">
            <label class="control-label" for="username">Username</label>
                <div class="controls">
                    <input type="text" class="input-xlarge required" name="username" id="username" value="<?php echo isset($username) ? $username : '';?>" />
                </div>
        </div> 
        <div class="control-group">
            <label class="control-label" for="password">Password</label>
                <div class="controls">
                    <input type="password" class="input-xlarge required" name="password" id="password" value="********"/>
                </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="branch_id">Branch</label>
                <div class="controls">
                    <?=form_dropdown('branch_id', create_dropdown('branches', 'name'), isset($branch_id) ? $branch_id: '', 'class="required"')?>
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