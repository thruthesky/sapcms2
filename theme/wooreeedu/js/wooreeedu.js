$ = jQuery;

var banner_count;
var banner_current_page = 1;
var is_animating = false;

$(function(){
	banner_count = $(".front-top-banner .banner").length - $(".front-top-banner .banner.fake").length;
	$("body").on("click",".front-top-banner .arrow",move_top_banner);
	
	$("body").on("click","#header-top #main-menu .contactUs", moveToContactUs);
});

function move_top_banner(){
	var $this = $(this);
	if( banner_count <= 1 ) return;
	if( is_animating == true ) return;
	
	is_animating = true;
	var $selector = $(".front-top-banner > .inner");
	var direction = $this.attr("direction");
	
	if( direction == 'left' ){
		banner_current_page --;
		animation_movement = banner_current_page * 100;
		do_banner_animation( "-" + animation_movement + "%", $selector, 500, direction );
	}
	else if( direction == 'right' ){
		banner_current_page ++;
		animation_movement = banner_current_page * 100;
		do_banner_animation( "-" + animation_movement+"%", $selector, 500, direction );
	}
}

function do_banner_animation( animation_movement, $selector, speed, direction){
	$selector.animate({
		left: animation_movement
	}, speed, function(){		
		is_animating = false;
		if( direction == 'left' ){
			if( banner_current_page < 1 ){
				var $selector = $(".front-top-banner > .inner");
				do_banner_animation( "-" + ( banner_count * 100 ) + "%", $selector, 0, 'last' );
			}
		}
		else if( direction == 'right' ){
			if( banner_current_page > banner_count ){
				var $selector = $(".front-top-banner > .inner");
				do_banner_animation( "-100%", $selector, 0, 'first' );
			}
		}
		else if( direction == 'first' ){
			banner_current_page = 1;
		}
		else if( direction == 'last' ){
			banner_current_page = banner_count;
		}
	});	
}

function moveToContactUs(){
	var $selector = $("#contactUs");
	var top = $selector.offset().top;
	$("body,html").animate({
		scrollTop:top}, '500', 'swing', 
		function() { 
			$selector.find("input[name='name']").focus();
		}
	);
}