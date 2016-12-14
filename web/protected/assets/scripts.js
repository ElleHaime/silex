$(function() {
	
    // Side Bar Toggle
    $('.hide-sidebar').click(function() {
	  $('#sidebar').hide('fast', function() {
	  	$('#content').removeClass('span9');
	  	$('#content').addClass('span12');
	  	$('.hide-sidebar').hide();
	  	$('.show-sidebar').show();
	  });
	});

	$('.show-sidebar').click(function() {
		$('#content').removeClass('span12');
	   	$('#content').addClass('span9');
	   	$('.show-sidebar').hide();
	   	$('.hide-sidebar').show();
	  	$('#sidebar').show('fast');
	});
	
	$('#cancel-to-list').click(function() {
		window.location.href = $(this).data('url');
	});
	
	$(".uniform_on").uniform();
	$('#news_post_intro').wysihtml5();
	$('#news_post_body').wysihtml5();
	
	$('#formPost').submit(function() {
		// validate URL 
		//
		$('#news_post_body_hidden').val($('#news_post_body').val());
		$('#news_post_intro_hidden').val($('#news_post_intro').val());
		$(this).submit();
	});
	
});