var subtotal = 0;

$(document).ready(function () {
	update_items_selection();	

	$('select[name="item-selection"]').chosen({no_results_text: "No results matched"});
	
	$('a[data-toggle="tab"]:first').tab('show');	
	$('#btnsubmit').hide();

	$('a[data-toggle="tab"]').on('show', function (e) {		
		if ($(e.currentTarget).attr('href') == '#payment') {
			$('#btnsubmit').show();
			$('#btn-next').hide();
		} else {
			$('#btn-next').show();
			$('#btnsubmit').hide();
		}
	});

	$('#btn-next').click(function () {
		$('a[data-toggle="tab"]').parents('li.active').next().children('a[data-toggle="tab"]').tab('show');
	});

	/** Order Type **/
	$('select[name="order_type"]').change(function () {		
		switch ($(this).val()) {
			case "1":
				show_pickup();
				break;
			case "2":
				show_delivery();
				break;
			default:
				$('#pickup-details, #delivery-details').addClass('hidden');
		}
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
						var item_id = val;

						if (qty % 1 == 0 && qty > 0 && item_id > 0) {
							$.ajax({
								url: BASE_URL + 'items/get_item_cost',
								type: 'post',
								dataType: 'json',
								data: 'item_id=' + item_id + '&qty=' + qty,
								success: function (data) {
								
									$('#order-form').append('<input type="hidden" id="item-' + val + '" name="items[]" value="' + val + '" />');
									$('#order-form').append('<input type="hidden" id="qty-' + val + '" name="qty[]" value="' + qty + '" />');
									$('#order-form').append('<input type="hidden" id="order_item-' + val + '" name="order_item[]" value="" />');

									$('#item-list tbody').append('<tr id="' + val + '"><td class="item-name">' + text + '</td><td>' + qty + ' </td><td>' + data.cost + '</td><td><a href="javascript:void(0)" class="item-remove">Remove</a></td></tr>');	
								
									update_items_selection(function () {
										subtotal += parseInt(data.cost);
										$('#subtotal').text(subtotal);
										$('input[name="order_cost"]').val(subtotal);

										update_grand_total();
										// Unset item-qty from DOM for validation the next time this dialog is opened the value is not confused over.
										$('input[name="item-qty"]').remove();
									});		
								}
							});
						}
						modal.dialog('close');
						$('#tmp-dialog').remove();											
					},	
					Cancel: function () {
						$(this).dialog('close');
						$('#tmp-dialog').remove();
					}
				}
				});
	});

	$('input[name="final_cost"]').change(function () {
		if ($(this).val() > 0) {
			$('input[name="order_cost"]').val($(this).val());
			update_grand_total();
		}
	});

	/** Remove item **/
	$('.item-remove').live('click', function () {
		var item_id = $(this).parents('tr').attr('id');

		subtotal -= $(this).parent().prev('td').text();		

		$('#subtotal').text(subtotal);									
		$('input[name="order_cost"]').val(subtotal);

		update_grand_total();

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

	$('input[name="order_cost"]').val($('#subtotal').text());

	$('input[name="delivery_cost"], input[name="special_cost"]').change(update_grand_total);

	/** Updating of grand total **/
	update_grand_total();

	$('select[name="payment_type_id"]').change(function() {		
		if ($(this).val() == 2) {
			
		}
	});
});

function update_grand_total() {
	$('#grand-total').text(
		parseInt($('input[name="order_cost"]').val()) + parseInt($('input[name="delivery_cost"]').val()) + parseInt($('input[name="special_cost"]').val())
	);
}

function show_pickup() {
	$('#pickup-details').removeClass('hidden');
	$('input, select', '#pickup-details').addClass('required');

	if (!$('#delivery-details').hasClass('hidden')) {
		$('#delivery-details').addClass('hidden');				
	}	
}

function show_delivery() {
	$('#delivery-details').removeClass('hidden');	
	//$('input, select', '#delivery-details').addClass('required');

	if (!$('#pickup-details').hasClass('hidden')) {
		$('#pickup-details').addClass('hidden');		
	}	
}
