$(document).ready(function () {        
    $('.accordion').accordion({
        autoHeight:false
    });
    
	$('.datepick').datepicker();
	$('.datetimepick').datetimepicker({
		ampm:true
	});	
	
    $('.jqgrow').live('dblclick', function () {
        $('#jqgrid-table').jqGrid('viewGridRow', $(this).attr('id'));
    });        
    
    $('#message-div').hide();

    $( "input:submit, a, button", ".jqui" ).button();    
    
    $('ul#navigation li a[href="' + window.location.toString() + '"]').addClass('active');
    
    // Delete.
    $('.delete').click(function (event) {
        var url = $(this).attr('href');
        var obj = $(this);
        
        event.preventDefault();
        bootbox.confirm("This record will be permanently deleted and cannot be recovered. Are you sure?", 
            function(confirmed) {
            if (confirmed) {
               $.ajax({
                    url: url,
                    success: function (data) {                    
                        if (data.response == 1)
                        {
                            obj.closest('tr').fadeOut('slow', function () {
                                obj.closest('tr').remove();
                                $('table.list tbody tr').attr('class','');
                                $('table.list tbody tr:odd').attr('class','colored');
                            });
                        }
                        $('#message-div').show();
                        $('#message-text').append(data.message).hide().fadeIn('slow');
                    },
                    dataType: 'json'
                });                
            }
        });        
    });
});

function update_items_selection(callback) {
    $('input[name="items[]"]').each(
        function(index, obj) 
        {
            $('select[name="item-selection"] option[value="' + $(obj).val() + '"]').remove();
        }
    );
    
    $('select[name="item-selection"]').trigger("liszt:updated");    
    if (typeof(callback) == typeof(Function)) {
        callback();
    }
}