<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="<?=site_url('items/purchasing')?>">Purchasing</a> <span class="divider">/</span>
  </li>
  <li class="active">Add/Edit</li>
</ul>

<?php if(validation_errors()):?>
    <div class="row-fluid">
        <span class="label label-important"><?=validation_errors()?></span>
    </div>
<?php endif;?>

<div class="row-fluid">
    <form action="" method="post" id="form-purchasing" class="form-horizontal require-validation">    
        <?php if (!isset($record_id)) {$record_id = '-1';}?>
        <input type="hidden" name="<?=$this->model->get_primary_key()?>" value="<?=$record_id?>" />        

        <div class=" well">
            <div class="control-group preconfirm">
                <label class="control-label" for="supplier_id">Name</label>
                    <div class="controls">
                        <?=form_dropdown('supplier_id', $this->suppliers->get_dropdown_array('name'), isset($supplier_id) ? $supplier_id : '', 'class="required" id="supplier_id"');?>
                    </div>
            </div>
            <div class="control-group preconfirm">
                <label class="control-label" for="item-selection">Items</label>
                    <div class="controls">
                        <select name="item-selection" class="span6" data-placeholder="Select item...">
                            <option value=""></option>
                            <?php if(isset($items_selection)):?>
                                <?php foreach ($items_selection as $item):?>
                                    <option value="<?=$item->item_id;?>"><?=$item->name?></option>
                                <?php endforeach;?>
                            <?php endif;?>
                        </select>
                    </div>
            </div>
        </div>
        <?php $total = 0;?>
        <div class="row-fluid">
            <div class="span-3">
                <table class="table table-bordered table-striped table-condensed" id="item-list">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                    <?php if(isset($order_items) && count($order_items)):               
                            if (!(is_array($order_items))) {
                                $order_items = array($order_items);
                            }
                    ?>
                        <?php foreach($order_items as $order_item): ?>
                        <tr id="<?php echo $order_item->item_id;?>">
                            <td class="item-name">
                                <?=$order_item->name?>
                                <input type="hidden" id="item-<?=$order_item->item_id;?>" name="items[]" value="<?=$order_item->item_id?>" />
                                <input type="hidden" id="qty-<?=$order_item->item_id?>" name="qty[]" value="<?=$order_item->quantity?>" />
                                <input type="hidden" id="order_item-<?=$order_item->order_item_id;?>" name="order_item[]" value="<?=$order_item->order_item_id?>" />
                            </td>
                            <td><?=$order_item->quantity?></td>
                            <td><?=$order_item->unit_cost?></td>
                            <td><?=$order_item->quantity * $order_item->unit_cost?></td>
                            <td><a href="javascript:void(0)" class="item-remove">Remove</a></td>
                        </tr>
                        <?php 
                            $total += $order_item->quantity * $order_item->unit_cost;
                        endforeach;?>
                    <?php endif;?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>Subtotal</strong></td>
                            <td><span id="subtotal"><?php echo (isset($total)) ? $total : '';?></span></td>
                            <td></td>
                        </tr>         
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="control-group  well">
            <div class="controls">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <input type="button" onclick="history.go(-1)" class="btn" value="Cancel"/>
            </div>
        </div>            
</form>

<script type="text/javascript">
    $(document).ready(function() {        
        var subtotal = 0;
        $('select[name="item-selection"]').chosen({no_results_text: "No results matched"});

        /** Select Item **/
        $('select[name="item-selection"]').chosen().change(function () {
            var text = $('select[name="item-selection"] option:selected').text();
            var val = $(this).val();

            bootbox.confirm('<p>Quantity <input class="required number" type="text" name="item-qty" /></p>Unit Price <input class="required number" type="text" name="unit-price" />', 
                function(confirmed) {
                if (confirmed) {
                    var qty = parseInt($('input[name="item-qty"]').val());
                    var unit_price = $('input[name="unit-price"]').val();
                    var modal = $(this);
                    var qty_ok = false;
                    var item_id = 0;

                    $('#form-purchasing').append('<input type="hidden" id="item-' + val + '" name="items[]" value="' + val + '" />');
                    $('#form-purchasing').append('<input type="hidden" id="qty-' + val + '" name="qty[]" value="' + qty + '" />');
                    $('#form-purchasing').append('<input type="hidden" id="cost-' + val + '" name="cost[]" value="' + qty + '" />');
                    $('#form-purchasing').append('<input type="hidden" id="order_item-' + val + '" name="order_item[]" value="" />');

                    $('#item-list tbody').append('<tr id="' + val + '"><td class="item-name">' + text + '</td><td>' + qty + ' </td><td>' + unit_price + '</td><td>' + qty * unit_price + '</td><td><a href="javascript:void(0)" class="item-remove">Remove</a></td></tr>');   
                
                    update_items_selection(function () {
                        subtotal += unit_price * qty;
                        $('#subtotal').text(subtotal);
                        $('input[name="order_cost"]').val(subtotal);
                        
                        // Unset item-qty from DOM for validation the next time this dialog is opened the value is not confused over.
                        $('input[name="item-qty"], input[name="unit-price"]').remove();
                    });                  
                }
            });           
        });      

        /** Remove item **/
        $('.item-remove').live('click', function () {
            var item_id = $(this).parents('tr').attr('id');

            subtotal -= $(this).parent().prev('td').text();     

            $('#subtotal').text(subtotal);            

            $('select[name="item-selection"]')
                .append($('<option></option>')
                            .val(item_id)
                            .text($(this).parent().siblings('.item-name').text())
                        );
                        
            $('#item-' + item_id).remove();
            $('#qty-' + item_id).remove();
            $('#cost-' + item_id).remove();
            $('select[name="item-selection"]').trigger("liszt:updated");

            $(this)
                .parents('tr')
                .fadeOut('slow')
                .remove();
        });    
    });
</script>