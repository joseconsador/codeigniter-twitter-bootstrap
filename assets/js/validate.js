$(document).ready(function () {
	$.validator.addMethod("phoneUS", 
			function(phone_number, element) {
    				phone_number = phone_number.replace(/\s+/g, ""); 
		
				return this.optional(element) || phone_number.length > 9 &&
					phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
				}, 
			"Please specify a valid phone number"
	);

    // Custom validation: check if past date.   
    $.validator.addMethod(
        'valid_date', 
        function (value) {
            var val = new Date(value);
            var now = new Date();
            
            if (val.getFullYear() < now.getFullYear())
            {              
                return false;
            }
            else if (val.getMonth() < now.getMonth())
            {
                return false;
            }
            else if (val.getDate() < now.getDate())
            {
                return false;
            }
            else
            {
                return true;
            }
        }, 
        'Please enter a valid date'
    );
    
    // Validate forms with class require-validation.
    // http://docs.jquery.com/Plugins/Validation
    $('form.require-validation').validate({
        highlight: function(label) {console.log($('a[href=#' + $(label).parents('.tab-pane').attr('id') + ']'));
            $(label).closest('.control-group').addClass('error');
            $('a[href=#' + $(label).parents('.tab-pane').attr('id') + ']').addClass('error').removeClass('valid');
        },
        success: function(label) {
            label
                .text('OK!').addClass('valid')
                .closest('.control-group').addClass('success');
            
            $('a[href=#' + $(label).parents('.tab-pane').attr('id') + ']').addClass('valid').removeClass('error');
        }        
    });
});
