
$(document).ready(function(){

	var login = $('#loginform');
	var recover = $('#recoverform');
    var kayit = $('#kayitform');

    var speed = 400;

	$('#to-recover').click(function(){
		
		$("#loginform").slideUp();
		$("#recoverform").fadeIn();
	});

	$('#to-login').click(function(){
		
		$("#recoverform").hide();
		$("#loginform").fadeIn();
	});

    $('#to-register').click(function(){

        $("#loginform").slideUp();
        $("#registerform").fadeIn();
    });

    $('#to-login2').click(function(){
        $("#registerform").hide();
        $("#loginform").fadeIn();
    });

    $('#to-login').click(function(){

    });
    $('#to-login2').click(function(){

    });



    if($.browser.msie == true && $.browser.version.slice(0,3) < 10) {
        $('input[placeholder]').each(function(){ 
       
        var input = $(this);       
       
        $(input).val(input.attr('placeholder'));
               
        $(input).focus(function(){
             if (input.val() == input.attr('placeholder')) {
                 input.val('');
             }
        });
       
        $(input).blur(function(){
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.val(input.attr('placeholder'));
            }
        });
    });

        
        
    }
});