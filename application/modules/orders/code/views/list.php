<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var order_id;

        $('#div-complete')                
            .dialog({
                autoOpen: false,
                title: 'Recepient Details', 
                modal: true,                
                buttons: {
                    "Ok": function () {
                            $('input[name="order_id"]').val(order_id);
                            $('#order-complete-form').trigger('submit');
                        }
                    },  
                    "Cancel": function () {
                        $(this).dialog('close');
                    }
            });         
        /** Mark item as complete **/
        $('a.complete-order').click(function () {
            order_id = $(this).parents('tr').attr('id');
            $('#div-complete').dialog('open');
        });        
    });
</script>
<div id="div-complete" class="hide">
    <form id="order-complete-form" class="require-validation" action="<?php echo site_url('orders/complete/')?>" method="post">
        <table>
            <tr>
                <td>Received By:</td>
                <td><input class="required" type="text" name="received_by" /></td>
            </tr>
            <tr>
                <td>Date:</td>
                <td><input class="datetimepick required" name="date_completed" type="text" /></td>
            </tr>
        </table>
        <input type="hidden" name="order_id" />
    </form>
</div>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li class="active">Orders</li>
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
                    <label class="control-label" for="control_number">Control Number</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="control_number" id="control_number" value="<?php echo isset($control_number) ? $control_number : '';?>" />
                        </div>
                </div>       
                <div class="control-group">
                    <label class="control-label" for="control_number">Status</label>
                        <div class="controls">
                            <?=form_dropdown('status', array('' => 'Select&hellip;', 'Paid' => 'Paid', 'Complete' => 'Complete'))?>
                        </div>
                </div>   
                <div class="control-group">
                    <label class="control-label" for="branch_id">Branch</label>
                        <div class="controls">
                            <?=form_dropdown('branch_id', create_dropdown('branches', 'name'), set_value('branch_id'));?>
                        </div>
                </div>      
                <div class="control-group">
                    <label class="control-label" for="">Date</label>
                        <div class="controls">
                            From <input type="text" class="datetimepick" name="date_start" value="<?=set_value('date_start')?>"/> 
                            To: <input type="text" class="datetimepick" name="date_end" value="<?=set_value('date_end')?>"/> 
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
    <?php if (isset($orders) && count($orders) > 0):?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><a href="#">ID</a></th>
                    <th>Control Number</th>
                    <th>Customer Name</th>                    
                    <th>Grand Total</th>
                    <th>Status</th>
                    <th>Date Created</th>                    
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order):?>
                <tr id="<?=$order->order_id?>">
                    <td><?=$order->order_id?></td>
                    <td><?=$order->control_number?></td>
                    <td><?=$order->firstname . ' ' . $order->lastname?></td>                    
                    <td><?=$order->grand_total?></td>
                    <td><?=$order->status?></td>
                    <td><?=date('M d, Y h:i a', strtotime($order->date_created))?></td>                    
                    <td>       
                        <a class="btn btn-info" href="<?=site_url('orders/view/' . $order->order_id)?>">
                            <i class="icon-info-sign icon-white"></i> 
                            View
                        </a>
                        <?php if ($order->status != 'Complete'):?>
                        <a href="javascript:void(0);" class="complete-order btn btn-primary">
                            <i class="icon-ok-sign icon-white"></i> 
                            Complete
                        </a>
                        <?php endif;?>
                        <?php if($this->user->is_admin && $order->status != 'Complete'):?>
                        <a class="btn btn-danger delete" href="<?=site_url('orders/delete/' . $order->order_id, 'Delete')?>">
                            <i class="icon-trash icon-white"></i> 
                            Delete
                        </a>  
                        <?php endif?>
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