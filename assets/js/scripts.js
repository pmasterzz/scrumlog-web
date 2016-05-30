
jQuery(document).ready(function() {
	
    /*
        Fullscreen background
    */
    $.backstretch("assets/img/backgrounds/bg3.jpg");
    
    /*
        Form validation
    */
    $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    $('.login-form').on('submit', function(e) {
    	
    	$(this).find('input[type="text"], input[type="password"], textarea').each(function(){
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	
    });
    $('#menu-toggle').click(function(){
            console.log('message');
            $(this).find('i').toggleClass('glyphicon-arrow-left glyphicon-arrow-right')
    });
    
                $('.cyclusDeleteBtn').click(function(event){
                    var c = confirm('Weet je het zeker?');
                    if(!c){
                        event.preventDefault();
                    }
                });
    
});


    

