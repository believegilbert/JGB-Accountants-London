// JavaScript Document
jQuery(document).ready(function ($) {

	// Regular Expression: Allow numbers only
	$(document).on('keypress', '.onlyNumber', function(e) {
 		var code = e.charCode || e.keyCode;
		//Allow backspace, delete, left arrow and right arrow keys
		if( e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 39){
		if (String.fromCharCode(code).match(/[^0-9\b]/g)) return false;
		}
     });

 	// Regular Expression: Allow letters, numbers, and spaces
	$(".alphanumeric").on('keypress', function (event) {
        if (event.charCode!=0) {
 			var regex = new RegExp("^[0-9a-zA-Z ]+$");
			var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
			if (!regex.test(key)) {
            event.preventDefault();
            return false;
			}
		}
    });

	// Regular Expression: Allow letters, numbers, and spaces
	$(".nospaces").on('keypress', function (event) {
         //Allow backspace, delete, left arrow and right arrow keys
         if ((event.charCode == 0 || event.charCode == 32) && event.keyCode != 8 && event.keyCode != 46 && event.keyCode != 37 && event.keyCode != 39) {
            event.preventDefault();
            return false;
 		}
    });
	// Regular Expression: Allow by pattern attribute. i.g. <input name="" type="text" class="allowSpclChar" data-pattern="[0-9a-zA-Z_-]" />"
	$(".allowSpclChar").on('keypress', function (event) {
		var pattern = $(this).data('pattern');
         if (event.charCode!=0) {
 			var regex = new RegExp("^"+pattern+"+$");
			var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
			if (!regex.test(key)) {
            event.preventDefault();
            return false;
			}
		}
    });

	$('form.validate input,form.validate textarea').focus(function() {
   		$(this).removeClass('error');
		$(this).next('i.error').remove();
 	}); 
	
	$('form.validate select, form.validate input:radio, form.validate input:checkbox').click(function() {
   		$(this).removeClass('error');
		$(this).next('i.error').remove();
 	});
     $('form.validate').submit(function () {
        var valid = true;
		$(this).css({position: 'relative'});
        $(this).find('i.error').remove();        
        $(this).find('label.security_error').remove();
        $(this).find('span.error-message').hide();


        $(this).find('.req').each(function () {
            if ($(this).val() == "") {
				$(this).addClass('error');
                //$(this).addClass('error').after('<i class="error tip" title="Required!">&nbsp;</i>');
                valid = false;
            } else if ($(this).hasClass('ajaxerror')) {
                $(this).addClass('error');
                valid = false;
            } else if ($(this).hasClass('req-email') && !checkemail($(this).val())) {
                //$(this).after('<i class="error tip" title="Invalid E-mail!">Invalid E-mail!</i>');
                $(this).addClass('error');
                valid = false;
            } else if ($(this).hasClass('req-num') && !checknum($(this).val())) {
                //$(this).after('<i class="error tip" title="Invalid! 10 Digit Mobile Number Required.">Invalid! 10 Digit Mobile Number Required.</i>');
                valid = false;
            }
        });

        $(this).find('.req_terms').each(function () {
            if (!$(this).is(':checked')) {
                // checkbox terms terms and condition
                alert('Please accept the terms and conditions');
                valid = false;
            }
        });

        if ($(this).find('input,textarea,select').hasClass('error')) {
            valid = false;

        }
		if(valid){
			if ($(this).hasClass('cnf_submit')) {
  				var msg = $(this).data('msg');
				var agree = confirm(msg);
				if (agree) valid = true; else valid = false;
			}
		}
 			
        if (!valid) {
			alert('Please correct the fields highlighted in red');
            return false;
        } else {
            $(this).find('.submit_btn').hide(); // Hide only submit button during the process
			$(this).find('input:submit').val('Processing...');
			
 		 if ($(this).hasClass('disable')) {
                var fWidth = $(this).width();
                var fHeight = $(this).height()+20;
                var fStyle = 'width:' + fWidth + 'px; height: ' + fHeight + 'px;';
				//alert(fStyle);
                $('<div style="' + fStyle + '" id="hform"></div>').prependTo(this);
            }
        }
    });

    //$('<div class="submitter">Please wait while we process your request... <br /> Do not press <strong>"refresh"</strong> or <strong>"back button"</strong> during the process.</div>').appendTo('form.validate');

});

function checkemail(e) {
    var emailfilter = /^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i
    return emailfilter.test(e);
}

function checknum(e) {
    var filter = /^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$/
    return filter.test(e);
}

//Check Characters Limit========================
function limitChars(id, char) {
	var wordCount = $(id).val().length;
	//var t = 'Limit: ' + char + ' , Remaining: ' + (char - wordCount);
	var t = (char - wordCount) +' characters left';

   $(id).parent().find('span.charsLimit').html(t);
   if (wordCount > char) {
      var v = $(id).val().substr(0, char)
      $(id).val(v);
      $(id).parent().find('span.charsLimit').html('<span class="redText">' + (wordCount - 1) + ' of ' + char + ' characters used </span>');
      // $('span#charCount').html('<strong>You may only have up to 100 characters.</strong>'); 
   }
   if ((char - wordCount) == 0) {
      $(id).parent().find('span.charsLimit').addClass('redText');
   }
   else {
      $(id).parent().find('span.charsLimit').removeClass('redText');
   }
}