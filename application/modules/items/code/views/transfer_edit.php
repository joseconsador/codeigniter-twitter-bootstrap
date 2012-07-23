<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li>
    <a href="<?=site_url('items/inventory/transfers')?>">Transfers</a> <span class="divider">/</span>
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

<form id="form-transfer" action="" method="post" class="form-horizontal well require-validation">
    <?php if (!isset($record_id)) {$record_id = '-1';}?>
    <input type="hidden" name="<?=$this->model->get_primary_key()?>" value="<?=$record_id?>" />    
    <div class="row-fluid">
        <?php if ($this->user->is_admin):?>    
            <div class="control-group preconfirm">
                <label class="control-label" for="branch_id_from">Branch From</label>
                <div class="controls">
                    <?=form_dropdown('branch_id_from', create_dropdown('branches', 'name'), isset($branch_id_from) ? $branch_id_from : '', 'class="required" id="branch_id_from"');?>
                </div>
            </div> 
        <?php else:?>
            <input type="hidden" id="branch_id_from" name="branch_id_from" value="<?=$this->user->branch_id?>" />
        <?php endif;?>
        <div class="control-group preconfirm">
            <label class="control-label" for="branch_id_to">Branch To</label>
            <div class="controls">
                <?=form_dropdown('branch_id_to', create_dropdown('branches', 'name'), isset($branch_id_to) ? $branch_id_to : '', 'class="required"');?>
            </div>
        </div>
        <div class="control-group preconfirm">
            <label class="control-label" for="code">Control Number</label>
            <div class="controls">
                <input type="text" class="required" name="code" value="<?php echo isset($code) ? $code : '';?>" />
            </div>
        </div>    

        <div class="controls">
            <input id="confirm-branch" class="btn" type="button" value="Confirm"/>
            <input id="cancel-branch" class="btn" type="button" value="Cancel"/>
        </div>     
    </div>
    <div class="row-fluid">
        <div id="ilist"><?php $this->load->view('item_list_modify');?></div>
    </div>

    <div class="control-group">
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
        $('#ilist').hide();
        $('#cancel-branch').hide();

        $('#item-list tr:last').remove();

        // Confirm
        $('#confirm-branch').click(function () {
            if ($('#form-transfer').valid()) {
                $('.preconfirm select').attr('disabled', 'disabled');
                $('input[name="code"]').attr('readonly', 'readonly');

                $('.preconfirm select').each(function (index, element) {
                    $('#form-transfer').append(
                        $('<input type="hidden" />')
                            .attr('name', $(element).attr('name')).val($(element).val())
                    );
                });

                $('#ilist').show();
                $('#cancel-branch').show();
                $(this).hide();   

                $.ajax({
                    url: BASE_URL + 'items/inventory/get_branch_inventory',
                    data: 'branch_id=' + $('#branch_id_from').val(),
                    dataType: 'json',
                    type: 'post',
                    success: function (items) {
                        $('select[name="item-selection"] option').remove();
                        $('select[name="item-selection"]').append($('<option></option>').val(''));

                        $.each(items, function(index, item) {
                            $('select[name="item-selection"]')
                                .append($('<option></option>').val(item.item_inventory_id).text(item.name));                                
                        });

                        $('select[name="item-selection"]').trigger("liszt:updated");
                    }
                });           
            } else {
                $('#ilist').hide();
                $('#cancel-branch').hide();
            }
        });

        // Cancel
        $('#cancel-branch').click(function () {            
            $('#ilist').hide();
            $('#confirm-branch').show();
            $(this).hide();
            $('select[name="item-selection"] option').remove();
            $('select[name="item-selection"]').trigger("liszt:updated");
            $('.preconfirm select').removeAttr('disabled');
            $('input[name="code"]').removeAttr('readonly');

            $('.preconfirm select').each(function (index, element) {
                $('input[name="' + $(element).attr('name') + '"]').remove();
            });

            $('#item-list tbody tr, input[name="items[]"], input[name="qty[]"], input[name="order_item[]"]').remove();
            $('#subtotal').text('0');
        });        


        /** Select Item **/
        $('select[name="item-selection"]').chosen().change(function () {
            var text = $('select[name="item-selection"] option:selected').text();
            var val = $(this).val();
            
            $('<div id="tmp-dialog"></div>')
                .html('Quantity <input class="required number" type="text" name="item-qty" />')
                .dialog({
                    title: 'Enter Quantity', 
                    modal: true,
                    buttons: {
                        "Ok": function () {
                            var qty = parseInt($('input[name="item-qty"]').val());
                            var modal = $(this);
                            var qty_ok = false;
                            var item_id = 0;

                            $.ajax({
                                url: BASE_URL + 'items/inventory/get_item',
                                type: 'post',
                                dataType: 'json',
                                data: 'item_inventory_id=' + val,
                                success: function (response) {
                                    console.log(qty);
                                    console.log(response.quantity);
                                    if (qty <= parseInt(response.quantity)) {
                                        qty_ok = true;
                                        item_id = response.item_id; 

                                        if (qty % 1 == 0 && qty > 0 && qty_ok && item_id > 0) {
                                            $.ajax({
                                                url: BASE_URL + 'items/get_item_cost',
                                                type: 'post',
                                                dataType: 'json',
                                                data: 'item_id=' + item_id + '&qty=' + qty,
                                                success: function (data) {                                                    
                                                    $('#form-transfer').append('<input type="hidden" id="item-' + val + '" name="items[]" value="' + val + '" />');
                                                    $('#form-transfer').append('<input type="hidden" id="qty-' + val + '" name="qty[]" value="' + qty + '" />');
                                                    $('#form-transfer').append('<input type="hidden" id="order_item-' + val + '" name="order_item[]" value="" />');

                                                    $('#item-list tbody').append('<tr id="' + val + '"><td class="item-name">' + text + '</td><td>' + qty + ' </td><td>' + data.cost + '</td><td><a href="javascript:void(0)" class="item-remove">Remove</a></td></tr>');   
                                                
                                                    update_items_selection(function () {
                                                        subtotal += data.cost;
                                                        $('#subtotal').text(subtotal);
                                                        $('input[name="order_cost"]').val(subtotal);
                                                        
                                                        // Unset item-qty from DOM for validation the next time this dialog is opened the value is not confused over.
                                                        $('input[name="item-qty"]').remove();
                                                    });     
                                                }
                                            });

                                            modal.dialog('close');
                                            $('#tmp-dialog').remove();
                                        }                                   
                                                        
                                    } else {
                                        alert('Request ('+ qty +') does not match stock. In stock : ' + response.quantity);
                                    }
                                }
                            });
                        },  
                        Cancel: function () {
                            $(this).dialog('close');
                            $('#tmp-dialog').remove();
                        }
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
            $('select[name="item-selection"]').trigger("liszt:updated");

            $(this)
                .parents('tr')
                .fadeOut('slow')
                .remove();
        });          
    });
</script>
