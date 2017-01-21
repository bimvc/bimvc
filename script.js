jQuery(document).ready(function($){

    var name = $('.name');
    var email = $('.email');
    var message = $('.message');
    var all = $('.name, .email, .message')

    $('#feedback').submit(function(e){
    	
    	e.preventDefault();
        var m_data=$(this).serialize();
        var pattern = /^[a-z0-9_-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;

      	if ( email.val() != '' ) {
      		if ( email.val().search(pattern) == 0 ){
      			var vEmail = true;
      		} else {
      			$('#simpleContactForm_btn').append('<span class="warning" style="padding-left: 10px;">e-mail не правильный</span>')
      			var vEmail = false;
      		}

      	} else if (email.val().length < 1) {
      		$('#simpleContactForm_btn').append('<span class="warning" style="padding-left: 10px;">поле e-mail пустое</span>')
      		var vEmail = false;
      	} else {
      		var vEmail = false;
      	}

        if ( name.val().length > 1 ){
          	var vName = true;
        } else {
          	$('#simpleContactForm_btn').append('<span class="warning" style="padding-left: 10px;">имя слишком короткое</span>')
          	var vName = false;  
        }

        if ( message.val().length > 5){
        	var vMessage = true;
        } else {
        	var vMessage = false;
        }

        if ( vEmail == true && vName == true && vMessage == true ){

        	$('.btn-theme-primary').removeClass('form-loading')
	        $.ajax({

	            type: "POST",
	            url: "/wp-admin/admin-ajax.php?action=sendfeedback",
	            data: m_data,
	            success: function(data) {

	            	$('.btn-theme-default').removeClass('form-loading')
	            	
	            	$('.form-control').css('opacity','0.5')
	            	$('.btn-theme-default').css('opacity','0.5') 

	                $('.btn').addClass('disabled')

	                $('.btn-theme-default').html("Отправлено")
	                $('#simpleContactForm_btn').append('<span style="padding-left: 10px;">Сообщение отправлено. Спасибо.</span>')
     
	                }
	            });
        } else {
        	$('.btn').addClass('disabled')
        }
    });

    all.focus(function(){
    	$("span.warning").remove();
		$(".btn").removeClass('disabled') 
    })

});

