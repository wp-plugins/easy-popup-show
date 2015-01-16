jQuery(document).ready(function($){

$('.eps_pop_close, #eps_background_overlay').on('click', function(){
$("#eps_user_name, #eps_user_email").val("");
});

	$(".eps_submit_button").on("click", function(e){
	e.preventDefault();
	});
	$(".epslinkshortcodebutton").on("click", function(e){
	e.preventDefault();
	});
	
/* 	$(".iris-square-inner, .ui-slider-handle, .ui-slider-vertical").on("click", function(){
	if($(".epslinkshortcodebutton").length > 0 && $(".pleaseupdate").length < 1 ) {
	$("<span class='pleaseupdate' style='color:#990000;'>Please update to preview the changes!</span><p>").insertBefore(".epslinkshortcodebutton");	
	}
	}); */
	
	$("#eps_elements, #eps_styles").find("input, select, textarea").on("change keyup click", function(){
	if($(".epslinkshortcodebutton").length > 0 && $(".pleaseupdate").length < 1 ) {
	$("<span class='pleaseupdate' style='color:#990000;'>Please update to preview the changes!</span><p>").insertBefore(".epslinkshortcodebutton");	
	}
	});		
	

});