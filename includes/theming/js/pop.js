jQuery(document).ready(function($){
/* if($("#eps_showedup_delay").length) {
var wait = $("#eps_showedup_delay").val();
$('#eps_popup_front, #eps_background_overlay').delay(wait).show(0);
// animation();
} else {
$('#eps_popup_front, #eps_background_overlay').show();
// animation();
} */

	function showpop(){
		$("#timer_container").removeAttr('style');
			$('#eps_popup_front').removeClass();
			$('#eps_popup_front, #eps_background_overlay').show();
	}
	
	if($("#eps_showedup_delay").length) {
	var wait = $("#eps_showedup_delay").val();
	setTimeout(showpop, wait);
	} else {
		showpop();
	}
});