<script type="text/javascript" src="<?js_dir('orders.js')?>"></script>
<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>
<h2>Add/Edit Order</h2>
<p id="error" <?php if (validation_errors()): ?>class="error"<?php endif; ?>>
    <?= validation_errors() ?>
</p>
<?php echo form_open('', 'id="order-form" class="require-validation"')?>
    <?php if(!$this->user->is_admin):?>        
        <input type="hidden" id="user_id" name="user_id" value="<?php echo $this->user->user_id;?>" />
        <input type="hidden" id="branch_id" name="branch_id" value="<?php echo $this->user->branch_id;?>" />
    <?php endif;?>    
    <div class="accordion">
        <?php if($this->user->is_admin):?>        
        <h3><a href="#">Details</a></h3>        
        <div>
			<?php $this->load->view('order/details');?>
        </div>
        <?php endif;?>
        <!-- Client tab -->
        <h3><a href="#">Client Info</a></h3>
        <div>
			<?php $this->load->view('order/client');?>
        </div>       
		<!-- Order tab -->
        <h3><a href="#">Order Info</a></h3>
        <div>
			<?php $this->load->view('order/order');?>
        </div>
		<!-- Payment tab -->
        <h3><a href="#">Payment Details</a></h3>
        <div>
			<?php $this->load->view('order/payment');?>
        </div>	
    </div>
    <div class="clearfix" style="margin-top:10px;"></div>
    <div class="grid_16">
        <input type="reset" value="Reset"/>
        <input type="submit" name="submit" value="Submit"/>

        <?php if (!isset($record_id)) {
            $record_id = '-1';
        } ?>
        <input type="hidden" name="<?= $this->model->get_primary_key() ?>" value="<?= $record_id ?>" />        
    </div>
<?php echo form_close()?>