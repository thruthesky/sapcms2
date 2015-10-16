$ = jQuery;

var banner_count;
var banner_current_page = 1;
var is_animating = false;

$(function(){
	banner_count = $(".front-top-banner .banner").length;
	$("body").on("click",".front-top-banner .arrow",move_top_banner);
});

function move_top_banner(){
	var $this = $(this);
	if( is_animating == true ) return;
	
	is_animating = true;
	var $selector = $(".front-top-banner .banner")
	var direction = $this.attr("direction");
	
	if( direction == 'left' ){
		banner_current_page --;
		animation_movement = banner_current_page * 100;
		do_banner_animation( "-" + animation_movement + "%", $selector, direction );
	}
	else if( direction == 'right' ){
		banner_current_page ++;
		animation_movement = banner_current_page * 100;
		do_banner_animation( "-" + animation_movement+"%", $selector, direction );
	}
}

function do_banner_animation( animation_movement, $selector, direction){
	$selector.animate({
		left: animation_movement
	}, 500, function(){		
		is_animating = false;
		if( direction == 'left' ){
			if( banner_current_page <= 1 ){
				alert('less');
			}
		}
		else if( direction == 'right' ){
			if( banner_current_page >= banner_count ){
				alert('more');
			}
		}
	});	
}