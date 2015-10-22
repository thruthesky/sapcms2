$ = jQuery;


var top_banner_data = {};
var featured_banner_data = {};
//var banner_count;
//var banner_current_page = 1;
var is_animating = false;

$(function(){
	initializeVariables();
	
	$("body").on("click",".front-top-banner .arrow",move_top_banner);
	
	$("body").on("click","#header-top #main-menu .contactUs", moveToContactUs);
	
	$("body").on("mouseenter","#header-top > .inner", showSubMenus);
	$("body").on("mouseleave","#header-top > .inner", closeSubMenus);

	$("body").on("click",".featuredPost .page-navigator .page-item",featuredPostAnimation);
	onResizeWindow();
	$(window).resize( onResizeWindow );
	
	//autoScrollFeaturedBanner();
	startFrontBanner();
	
	$("body").on("mouseenter",".front-top-banner",stopFrontBanner);
	$("body").on("mouseleave",".front-top-banner",startFrontBanner);
	
	$("body").on("mouseenter",".featuredPost",stopFeaturedBanner);
	$("body").on("mouseleave",".featuredPost",startFeaturedBanner);
});

function initializeVariables(){
	if( $(".front-top-banner").length ){		
		if( typeof( top_banner_data.banner_count ) == 'undefined' ) top_banner_data.banner_count = $(".front-top-banner .banner").length - $(".front-top-banner .banner.fake").length;
		if( typeof( top_banner_data.banner_current_page ) == 'undefined' ) top_banner_data.banner_current_page = 1;	
	}
	if( $(".featuredPost").length ){
		if( typeof( featured_banner_data.banner_count ) == 'undefined' ) featured_banner_data.banner_count = $(".featuredPost .item").length - $(".featuredPost .item.fake").length;
		if( typeof( featured_banner_data.banner_current_page ) == 'undefined' ) featured_banner_data.banner_current_page = 1;
	}
}

function move_top_banner(){
	var $this = $(this);		
	
	
	if( top_banner_data.banner_count <= 1 ) return;
	if( is_animating == true ) return;
	
	is_animating = true;
	var $selector = $(".front-top-banner > .inner");
	var direction = $this.attr("direction");	
	
	if( direction == 'left' ){
		top_banner_data.banner_current_page --;
		animation_movement = top_banner_data.banner_current_page * 100;
		do_banner_animation( "-" + animation_movement + "%", $selector, 500, direction, top_banner_data );
	}
	else if( direction == 'right' ){
		top_banner_data.banner_current_page ++;
		animation_movement = top_banner_data.banner_current_page * 100;
		do_banner_animation( "-" + animation_movement+"%", $selector, 500, direction, top_banner_data );
	}
}

var topAutoBanner;
function autoScrollTopBanner(){
	topAutoBanner = setTimeout( function(){
		var $selector = $(".front-top-banner > .inner");
		top_banner_data.banner_current_page ++;
		animation_movement = top_banner_data.banner_current_page * 100;
		do_banner_animation( "-" + animation_movement+"%", $selector, 500, 'right', top_banner_data );
		autoScrollTopBanner()
	},5000);
}

function stopFrontBanner(){
	clearTimeout( topAutoBanner );
}

function startFrontBanner(){
	autoScrollTopBanner();
}

function do_banner_animation( animation_movement, $selector, speed, direction, data){
	console.log( data );
	//console.log( direction );
	$selector.animate({
		left: animation_movement
	}, speed, function(){		
		is_animating = false;
		if( direction == 'left' ){
			if( data.banner_current_page < 1 ){				
				do_banner_animation( "-" + ( data.banner_count * 100 ) + "%", $selector, 0, 'last', data );
			}
		}
		else if( direction == 'right' ){			
			if( data.banner_current_page > data.banner_count ){				
				do_banner_animation( "-100%", $selector, 0, 'first', data );
			}
		}
		else if( direction == 'page' ){ //page jump
			
		}
		else if( direction == 'first' ){
			data.banner_current_page = 1;
		}
		else if( direction == 'last' ){
			data.banner_current_page = data.banner_count;
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

var subMenuTimeoutIn;
var subMenuTimeoutOut;
function showSubMenus(){
	clearTimeout( subMenuTimeoutOut );
	subMenuTimeoutIn = setTimeout(function(){
		$("#header-top .sub-menu").slideDown();
		autoScrollFeaturedBanner();
	},200);
}

function closeSubMenus(){
	clearTimeout( subMenuTimeoutIn );
	subMenuTimeoutOut = setTimeout(function(){
		$("#header-top .sub-menu").slideUp();
		stopFeaturedBanner();
	},200);
}

function onResizeWindow(){
	difference = ( $(window).width() - 960 ) / 2 + 10;
	if( difference < 10 ) difference = 10;
	$(".front-top-banner .arrow[direction='left']").css("left",difference);
	$(".front-top-banner .arrow[direction='right']").css("right",difference);
	
}

function featuredPostAnimation(){
	$this = $(this);	
	
	page_now = $this.parents(".featuredPost").find(".page-item.is-active").attr('page');
	clicked_page = $this.attr("page");
	featured_banner_data.banner_current_page = clicked_page;
	
	page_diff = page_now - clicked_page;
	if( page_diff == 0 ){
		return;
	}
	
	$(".featuredPost .page-navigator .page-item.is-active").removeClass("is-active");
	$this.addClass('is-active');
	$selector = $(".featuredPost > .inner");

	animation_movement = ( page_now - page_diff ) * 100;
	do_banner_animation( "-" + animation_movement + "%", $selector, 500, 'page', featured_banner_data );
}

var featuredAutoBanner;
function autoScrollFeaturedBanner(){	
	featuredAutoBanner = setTimeout(function(){
		page_now = featured_banner_data.banner_current_page;		
		clicked_page = parseInt( page_now ) + 1;
		featured_banner_data.banner_current_page = clicked_page;
		page_diff = page_now - clicked_page;
		if( clicked_page > featured_banner_data.banner_count ) clicked_page = 1;
		$(".featuredPost .page-navigator .page-item.is-active").removeClass("is-active");
		$(".featuredPost .page-navigator .page-item[page='" + clicked_page + "']").addClass("is-active");
		
		$selector = $(".featuredPost > .inner");
		animation_movement = ( page_now - page_diff ) * 100;
		do_banner_animation( "-" + animation_movement + "%", $selector, 500, 'right', featured_banner_data );
		autoScrollFeaturedBanner();
	}, 2000 );
}

function stopFeaturedBanner(){
	clearTimeout( featuredAutoBanner );
}

function startFeaturedBanner(){
	autoScrollFeaturedBanner();
}