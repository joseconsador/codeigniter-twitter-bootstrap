<script type="text/javascript" src="<?js_dir('orders.js')?>"></script>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="<?=site_url('orders')?>">Orders</a> <span class="divider">/</span>
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

<?php echo form_open('', 'id="order-form" class="require-validation"')?>
    <?php if(!$this->user->is_admin):?>        
        <input type="hidden" id="user_id" name="user_id" value="<?php echo $this->user->user_id;?>" />
        <input type="hidden" id="branch_id" name="branch_id" value="<?php echo $this->user->branch_id;?>" />
    <?php endif;?>    
    <ul class="nav nav-tabs">
        <?php if($this->user->is_admin):?>        
        <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
        <?php endif;?>
        <!-- Client tab -->
        <li><a href="#client" data-toggle="tab">Client Info</a></li>      
		<!-- Order tab -->
        <li><a href="#order" data-toggle="tab">Order Info</a></li>
		<!-- Payment tab -->
        <li><a href="#payment" data-toggle="tab">Payment Details</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="details"><?php $this->load->view('order/details');?></div>
        <div class="tab-pane" id="client"><?php $this->load->view('order/client');?></div> 
        <div class="tab-pane" id="order"><?php $this->load->view('order/order');?></div>        
        <div class="tab-pane" id="payment"><?php $this->load->view('order/payment');?></div>          
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
<?php echo form_close()?>