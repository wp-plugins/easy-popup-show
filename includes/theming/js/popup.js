jQuery(document).ready(function($){

$.each(['show', 'hide'], function (i, ev) {
        var el = $.fn[ev];
        $.fn[ev] = function () {
          this.trigger(ev);
          return el.apply(this, arguments);
        };
      }); 

if($("#timer_container").length){
var tmr = parseInt($('.tiny_timer').html());
}

  function doUpdate() {
  if(!! $("#timer_container")) {
    $('.tiny_timer').each(function(e) {
      var count = parseInt($(this).html());
      if (count !== 0) {
		if($('#eps_popup_front').css('display') != 'none'){
        $(this).html(count - 1);
		}
      } else {
	  $(this).closest('#timer_container').css('display', 'none');
	  if($('#eps_popup_front').css('display') != 'none'){
		if(!! $("#eps_animation_out")) {
		var animout = $("#eps_animation_out").val();
			$('#eps_popup_front').removeClass();
			$('#eps_popup_front').addClass('animated ' + animout);
		} else {
		$('#eps_popup_front, #eps_background_overlay').hide();
		}
		$('#eps_popup_front').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
		$('#eps_popup_front, #eps_background_overlay').hide();
		});	
		}
		$(this).html(tmr);	
	  }
	 if($('#eps_popup_front').css('display') != 'none'){
	$("#eps_user_name, #eps_user_email, .eps_submit_button").on("mouseover keyup mousemove click", function(){
		$('.tiny_timer').html(count + 1);	
	  });
	   }	
    });
  }
}

	function showpop(){
			$('#eps_popup_front').removeClass();
			$('#eps_popup_front, #eps_background_overlay').show();
	}
 	$(".epslinkshortcode").on("click", function(e){
	e.preventDefault();
	$("#timer_container").removeAttr('style');
	if($("#eps_showedup_delay").length) {
	var wait = $("#eps_showedup_delay").val();
	setTimeout(showpop, wait);
	} else {
		showpop();
	}
	});
$('#eps_popup_front').on('show', function(){
if($("#eps_animation_in").length) {
var animtype = $("#eps_animation_in").val();
	$('#eps_popup_front').addClass('animated ' + animtype);
}
$('.tiny_timer').html(tmr);
if($("#timer_container").length){
		if(!$("#timer_container").hasClass("clicked")) {
		$("#timer_container").addClass("clicked");
		setInterval(doUpdate, 1000);
		}
}
});	

// ANIMATE


var prev_cta = $("#call_to_act").html();
	function validateEmail(email) {
		var re = /\S+@\S+\.\S+/;
		return re.test(email);
	}
	
$('.eps_submit_button').on('click', function(e){
$(this).prop("disabled",true);
e.preventDefault();
var name = $('#eps_user_name').val();
var email_address = $('#eps_user_email').val();
if(name == '' || email_address == '') {
$("#call_to_act").html('Please complete the required field!').css('color', '#990000');
$('.eps_submit_button').prop("disabled",false);
} else if(validateEmail(email_address) == false) {
$('.eps_submit_button').prop("disabled",false);
$("#call_to_act").html('Email not valid!').css('color', '#990000');
} else {
$("#call_to_act").html(prev_cta).removeAttr('style');
$('.eps_submit_button').prop("disabled",false);
$('.loading ').show();
$('.eps_pop_close ').hide(500);
	var data = {
		'action': 'mchimp_subscribe',
		security : epsSubmit.security,
		'name': name,
		'email': email_address
	};

	$.post(epsSubmit.ajaxurl, data, function(response) {
	
	$('.loading ').hide(500);
/* 		$(window).on('beforeunload', function(){
			return false;
		}); */
	$('.eps_pop_close').show(500);

		if($('#redir_url').length != 1) {
			$('#eps_popup_inner, #email_form_container, #tm_container').hide(500);
			$('#result_message').show(500);
		}
		// alert(response);
		
		if(response.indexOf('EPS Success Message') >= 0) {			
			if($('#redir_url').length) {
				window.location = $('#redir_url').val();
			} else {
				$('.success_message').show(500);
			}
		} else if(response.indexOf('Mailchimp_List_AlreadySubscribed') >= 0 || response.indexOf('List Already Subscribed') >= 0) {
			$('.subscriber_exist').show(500);
		} else {
			$('.other_error').show(500);
			$('.try_again').on('click', function(e){
			e.preventDefault();
						$('#eps_popup_inner, #email_form_container, #tm_container').show(500);
						$('#result_message, .other_error').hide(500);
			});

			// window.suggestmeyes_loaded = true;
		}
	
		// alert(response);	
	});
	
}
});

$('.eps_pop_close, #eps_background_overlay').on('click', function(){

// ANIMATE OUT
if($("#eps_animation_out").length) {
var animout = $("#eps_animation_out").val();
	$('#eps_popup_front').removeClass();
	$('#eps_popup_front').addClass('animated ' + animout);
} else {
$('#eps_popup_front, #eps_background_overlay').hide();

}
	$('#eps_popup_front').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
	$('#eps_popup_front, #eps_background_overlay').hide();
	});
});

/* function checkwidth(){
    if($(window).width() <= 240){
	
	}
}

$(window).on('resize', function (){

  // $(window).height();
}); */
});