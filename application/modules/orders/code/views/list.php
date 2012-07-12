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
<div id="div-complete">
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

<h3>Filter</h3>
<form id="search-form" method="get" action="">
    <div class="grid_3">
        <p>
            <label>Control Number</label>
            <input type="text" name="control_number" value="<?=set_value('control_number');?>"/>
        </p>       
    </div>
    <div class="grid_3">
        <p>
            <label>Status</label>
            <?=form_dropdown('status', array('' => 'Select&hellip;', 'Paid' => 'Paid', 'Complete' => 'Complete'))?>
        </p>
    </div>
    <div class="grid_4">
        <p>
            <label>Branch</label>       
            <?=form_dropdown('branch_id', 
                    create_dropdown('branches', 'name'),
                    set_value('branch_id')
                );
                ?>
        </p>
    </div>
    <div class="clear"></div>
    <div class="grid_6">
        <p>
            <label>Date</label>
            From <input type="text" class="datetimepick" name="date_start" value="<?=set_value('date_start')?>"/> 
            To: <input type="text" class="datetimepick" name="date_end" value="<?=set_value('date_end')?>"/> 
        </p>
    </div>
    <div class="clear"></div>
    <h3>Order By</h3>
    <div class="grid_3">
        <p>            
            Field: <?=form_dropdown('sort_by', $sort, set_value('sort_by'))?>
        </p>
    </div>
    <div class="grid_2">
        <p>            
            Direction: <?=form_dropdown('direction', array('desc' => 'Descending', 'asc' => 'Ascending'), set_value('direction'))?>
        </p>
    </div>    
    <div class="clear"></div>
    <input type="submit" value="Search" />
    <input type="hidden" name="search" value="1" />        
</form>

<div class="clearfix"></div>
<h3>Orders</h3>
<div class="grid_16">
    <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-plus"></span>
    <?=anchor('orders/form', 'Add');?>
</div>
<div class="grid_16">
    <?php if (isset($orders) && count($orders) > 0):?>
        <table class="">
            <thead>
                <tr>
                    <th>ID</th>
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
                        <?php if ($order->status != 'Complete'):?>
                        <span style="float:left;">                           
                            <span style="float:left;" class="ui-icon ui-icon-tag"></span>
                            <a href="javascript:void(0);" class="complete-order">Complete</a>
                        </span>
                        <?php endif;?>
                        <span style="float:left;">
                            <span style="float:left;margin-right: .3em;" class="ui-icon ui-icon-zoomin"></span>
                            <?=anchor('orders/view/' . $order->order_id, 'View');?>                           
                        </span>
                        <?php if($this->user->is_admin && $order->status != 'Complete'):?>
                        <span>
                            <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-cancel"></span>
                            <?=anchor('orders/delete/' . $order->order_id, 'Delete', 'class="jqdelete"');?>
                        </span>
                        <?php endif;?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" class="pagination">
                        <?php echo $this->pagination->create_links(); ?>
                    </td>
                </tr>                
            </tfoot>
        </table>
        <div id="dialog-confirm" title="Delete this order?">
            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This record will be permanently deleted and cannot be recovered. Are you sure?</p>
        </div>    
    <?php endif;?>
</div>