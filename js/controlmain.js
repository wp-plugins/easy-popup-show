jQuery(document).ready(function($){
	
	var a = "{\n";
	var z = "}";
	
	function buttonStyle(first, second) {

	var bggrt = $('#EPSBtngradienttop').val();
	var bggrb = $('#EPSBtngradientbottom').val();
	var style = first + a;
	style += bggrt != "" ? "background: " + bggrt + " !important;\n" : bggrb != "" && bggrt == "" ? "background: " + bggrb + " !important;\n" : "";
	stylehover = "";
	if(bggrt != "" && bggrb != "") {
			style += "background: -moz-linear-gradient(top, " + bggrt + " 5%, " + bggrb + " 100%) !important;\n" ;
			style += "background: -webkit-gradient(linear, left top, left bottom, color-stop(5%, " + bggrt + "), color-stop(100%, " + bggrb + " )) !important;\n";
			style += "background: -webkit-linear-gradient(top, " + bggrt + " 5%, " + bggrb + " 100%) !important;\n";
			style += "background: -o-linear-gradient(top, " + bggrt + " 5%, " + bggrb + " 100%) !important;\n";
			style += "background: linear-gradient(to bottom, " + bggrt + " 5%, " + bggrb + " 100%) !important;\n";
			style += 'filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="' + bggrt + '", endColorstr="' + bggrb + '",GradientType=0 ) !important;\n';
			style += '-ms-filter: "progid:DXImageTransform.Microsoft.gradient( startColorstr=\''+ bggrt +'\', endColorstr=\''+ bggrb +'\',GradientType=0 )" !important;\n';
			stylehover += "\n" + second + a;
			stylehover += "background: -moz-linear-gradient(top, " + bggrb + " 5%, " + bggrt + " 100%) !important;\n" ;
			stylehover += "background: -webkit-gradient(linear, left top, left bottom, color-stop(5%, " + bggrb + "), color-stop(100%, " + bggrt + " )) !important;\n";
			stylehover += "background: -webkit-linear-gradient(top, " + bggrb + " 5%, " + bggrt + " 100%) !important;\n";
			stylehover += "background: -o-linear-gradient(top, " + bggrb + " 5%, " + bggrt + " 100%) !important;\n";
			stylehover += "background: linear-gradient(to bottom, " + bggrb + " 5%, " + bggrt + " 100%) !important;\n";
			stylehover += 'filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="' + bggrb + '", endColorstr="' + bggrt + '",GradientType=0 ) !important;\n';
			stylehover += '-ms-filter: "progid:DXImageTransform.Microsoft.gradient( startColorstr=\''+ bggrb +'\', endColorstr=\''+ bggrt +'\',GradientType=0 )" !important;\n';		
			stylehover += z;
	}
	style += z;
	
	var third = '\n#eps_popup_front input[type="submit"]:active {\nposition:relative;\ntop:1px;\n}';
	
	var total = style + stylehover + third;
	return total;
	}
	
	
	function fillitTo() {	
	if(buttonStyle() != "") {
		$("#eps_btn_style").val(buttonStyle('#eps_popup_front input[type="submit"] ', '#eps_popup_front input[type="submit"]:hover '));
	}
	}
	fillitTo();
	
	function appendHead() {
	// if($('style#epsButtonStyleTag').length>0) {
	$('#epsButtonStyleTag').remove();
	// }
	if($("#btn_usethis").is(":checked")) {
	var hs = $("<style />", { id  : 'epsButtonStyleTag',
	type: 'text/css',
	html: "" + buttonStyle(".button_field_value ", ".button_field_value:hover ")})
	.appendTo("head");
	}
	}
if($("#btn_usethis").is(":checked")) {
 appendHead();
 $(".button_field_value").css('color', $("#button_text_color").val() + " !important");
}
/* ON INPUT CHANGE */

$("#btn_usethis").on("change", function(){
	if($(this).is(":checked")) {
	appendHead();
	$(".button_field_value").css('color', $("#button_text_color").val() + " !important");
	} else {
	$('#epsButtonStyleTag').remove();
	$(".button_field_value").css('color', "#ffffff");
	}
});
var prev = "";
var currt = "";
	$.each($('#btn_ruler').find("input, select"), function(i, v){
			$("#" + v.id).on("change cut paste keyup", function(){
			prev += $('#eps_btn_style').val();
					fillitTo();
			currt += $('#eps_btn_style').val();
				$('#eps_btn_style').change();
			});
	});
	
function getContrastYIQ(hexcolor){
	var r = parseInt(hexcolor.substr(0,2),16);
	var g = parseInt(hexcolor.substr(2,2),16);
	var b = parseInt(hexcolor.substr(4,2),16);
	var yiq = ((r*299)+(g*587)+(b*114))/1000;
	return (yiq >= 175) ? 'black' : 'white';
}	

$("#button_text_color, #EPSBtngradienttop, #EPSBtngradientbottom, #btn_ftscolor, #btn_stscolor, #btn_bcolor, #btn_fbscolor, #btn_sbscolor").iris({
    change: function(event, ui){	
    $(this).css( 'background', ui.color.toString());
	var hexcolor = ui.color.toString().substring(1);	
	var tr = getContrastYIQ(hexcolor);
		$(this).css('color', tr);
	}
});	
$("#button_text_color, #EPSBtngradienttop, #EPSBtngradientbottom, #btn_ftscolor, #btn_stscolor, #btn_bcolor, #btn_fbscolor, #btn_sbscolor").each(function(i, v) {
	$(v).css( 'background', $(v).val());
	var hexcolor = $(v).val().substring(1);	
	var tr = getContrastYIQ(hexcolor);
	$(v).css( 'color', tr);
});

	$(document).on('click', function(e){		
		if($(e.target).parents().is("#spforbtnfield")) {
			$(".savebuttoneditor").val("not_saved");
		}
		
		if($(".savebuttoneditor").val() != "") {
			if(!$(e.target).parents().is("#spforbtnfield")) {
				$(".savebuttoneditor").val("");
			}
		}
	});


	$(".iris-picker, .iris-square-handle").on('mouseup mousedown', function(){
				$(this).prev("input").change();
		if($("#btn_usethis").is(":checked")) {		
		$(".button_field_value").css('color', $("#button_text_color").val() + " !important");
		}
	});	
	
	$(".iris-picker, .iris-square-handle").on('click', function(e){
	e.preventDefault();
	});

	$('#enabletextshadow').on('change', function(){
		if ($(this).is(':checked')) {
			$(this).parents().find('.enablebtntextshadow').show();
		} else {
			$(this).parents().find('.enablebtntextshadow').hide();
		}
	});
		if ($('#enabletextshadow').is(':checked')) {
			$('#enabletextshadow').parents().find('.enablebtntextshadow').show();
		} else {
			$('#enabletextshadow').parents().find('.enablebtntextshadow').hide();
		}
	$('#enablegradient').on('change', function(){
		if ($(this).is(':checked')) {
			$(this).parents().find('#EPSBtngradientbottom').attr("disabled", false);
		} else {
			$(this).parents().find('#EPSBtngradientbottom').attr("disabled", true).val('').css('background', '');
			fillitTo();
			$('#eps_btn_style').change();
		}
	});

	$('#eps_btn_style').on('change', function(){
			if(prev != currt){
				appendHead();
			}
		
	});
	
	
});