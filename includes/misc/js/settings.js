jQuery(document).ready(function($){

		$('.header_area').on('click', function(){
				var color = $(this).css('background-color');
				var form = $(this).closest('.eps_form');
				var set = $(this).closest('.eps_form').find('.settings_content');
				var sign = $(this).find('.plus_min');
			if(set.css('display') === 'none') {
			
				form.css({
				position : 'absolute',
				top : '5%',
				left: 0,
				width: '100%',
				'z-index' : 999
				});
				sign.removeClass('hide').addClass('show');
				set.fadeIn(500);
				$(window).scrollTop(0);				
			} else {
			
				form.attr('style', ' ');
				sign.removeClass('show').addClass('hide');
				set.fadeOut(500);
				$('html,body').animate({ scrollTop: form.offset().top - 35 }, 'slow');
				$(this).animate({backgroundColor: '#f0a524'}, 'slow');
				$(this).animate({backgroundColor: color}, 'slow');			
			
			}
		});
		
});