$ = jQuery;

var banner_count;
var banner_current_page = 0;
var is_animating = false;

$(function(){
	banner_count = banner_count = $(".front-top-banner .banner").length;
	$("body").on("click",".front-top-banner .arrow",move_top_banner);
});

function move_top_banner(){
	var $this = $(this);
	if( is_animating == true ) return;
	
	is_animating = true;
	var $selector = $(".front-top-banner .banner")
	
	if( $this.hasClass('left') ){
		banner_current_page --;
		animation_movement = banner_current_page * 100;
		do_banner_animation( "-"+animation_movement + "%", $selector );
	}
	else if( $this.hasClass('right') ){
		banner_current_page ++;
		animation_movement = banner_current_page * 100;
		do_banner_animation( "-" + animation_movement+"%", $selector );
	}
}

function do_banner_animation( animation_movement, $selector){
	$selector.animate({
		left: animation_movement
	}, 500, function(){		
		is_animating = false;
	});	
}