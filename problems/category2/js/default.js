// JavaScript Document
( function( $ ) { 
 
	//Smoothly return anywhere in a page
	smoothScroll = function (obj, speed, adj_height) {
	   var y = $(obj).offset().top;
	   $('html, body').delay(20).animate({scrollTop: y - adj_height}, speed);
	}
	
	//JavaScript Random Integers
	getRndInteger = function (min, max) {
	  return Math.floor(Math.random() * (max - min) ) + min;
	}	
	
	//========================
	//Check Characters Limit
	//========================
	limitChars = function (id, char) {
		var wordCount = $(id).val().length;
		//var t = 'Limit: ' + char + ' , Remaining: ' + (char - wordCount);
		var t = (char - wordCount) +' characters left';

	   $(id).parent().find('span.charsLimit').html(t);
	   if (wordCount > char) {
		  var v = $(id).val().substr(0, char);
		  $(id).val(v);
		  $(id).parent().find('span.charsLimit').html('<span class="redText">' + (wordCount - 1) + ' of ' + char + ' characters used </span>');       
	   }
	   if ((char - wordCount) == 0) {
		  $(id).parent().find('span.charsLimit').addClass('redText');
	   }
	   else {
		  $(id).parent().find('span.charsLimit').removeClass('redText');
	   }
	}

 
	
	// Redirect page
	redirect = function (url){
		window.location.href = url;
	}
	
  
	//Ajax post form
	postForm = function (obj, url, remove_form = false){
		//var postData = obj.serializeArray();
		var  scrollTo_obj = 'scrollTo'+getRndInteger(1,999);	
		//obj.css({position: 'relative'});
		obj.find('.response').remove();
		
		var formdata = false;
		if (window.FormData){
			formdata = new FormData(obj[0]);
		}
			
		$.ajax({
			url: url,
			type: "POST",
			//data: postData, 	
			data: formdata ? formdata : obj.serialize(),
			dataType: "json",
			async: true,
			cache: false,
			processData: false, // Don't process the files
			contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			enctype: 'multipart/form-data',			
			beforeSend: function() {
				var fWidth = obj.width();
				var fHeight = obj.height();
				var fStyle = 'width:' + fWidth + 'px; height: ' + fHeight + 'px;';
				obj.append('<div class="response"><span class="ajax_submitter" style="' + fStyle + '">&nbsp;</span></div>');
				//obj.append('<span class="response"><span class="ajaxLoader">Processing... Please Wait.</span></span>');
			}
		})
		.done(function(data) {
			if(data.success){
				//obj.html(data.successMsg);
				
				if(remove_form == true){
					obj.parent().html('<span class="msg" id="'+scrollTo_obj+'">'+data.successMsg+'</span>'); 
					smoothScroll('#'+scrollTo_obj, 300, 100);
				}else{
					obj.find('.response').html(data.successMsg);
				}
			} 
			if(data.error){ 
				obj.find('.response').html('<span class="redMsg"><span>'+data.errorMsg+'</span></span>');
				
				/*
				if($('#g-recaptcha-response').length > 0){
					//get new recaptcha token
					grecaptcha.ready( function () {
					grecaptcha.execute( '6Lc81YkUAAAAAMEoVgnQUyEL8v4XcJxVxFGpFv-N', {
						action: 'ajax_submit'
					}).then( function ( token ) {
						document.getElementById( 'g-recaptcha-response' ).value = token;
					});
					});
				}
				*/
			}
		})
		.fail(function(xhr, textStatus, error) {
			/*
			if($('#g-recaptcha-response').length > 0){
				//get new recaptcha token
				grecaptcha.ready( function () {
				grecaptcha.execute( '6Lc81YkUAAAAAMEoVgnQUyEL8v4XcJxVxFGpFv-N', {
					action: 'ajax_submit'
				}).then( function ( token ) {
					document.getElementById( 'g-recaptcha-response' ).value = token;
				});
				});
			} 
			*/
			 alert(error+" Error occured. please try again. ");
			 obj.find('.response').remove();
		}); 
		
	return false;
	}
 
// ----------------------------------------------------------------------


jQuery(document).ready(function ($) {
	$(document).on('click','.errorMsg span.c, .msg span.c',function(){$(this).parent().slideUp()});
	$( window ).scroll(function() { var y = $(this).scrollTop(); if(y>72) $("#back-top").fadeIn(); else  $("#back-top").fadeOut(); });
	$("#back-top a").on('click', function () { smoothScroll('body', 300, 10); return false;});
	$("a.jump_link").on('click', function () { var obj= $(this).attr('href'); smoothScroll(obj, 300, 0); return false;});
	
	// ----------------------------------------------------------------------
	
	$("a.callback_btn").on('click', function () {  smoothScroll('#footer_top', 300, 0); return false;});
	$(".goto_contact_form").on('click', function () {  
		smoothScroll('#contact-form-main', 300, 50); 
		$( "#contact-form-main" ).delay(800).effect( "shake" );
		return false;
	});	
	
});  	
})( jQuery );
 





