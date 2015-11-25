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
	if( $(".front-top-banner").length ){
		startFrontBanner();
		$("body").on("mouseenter",".front-top-banner",stopFrontBanner);
		$("body").on("mouseleave",".front-top-banner",startFrontBanner);
	}
	$("body").on("mouseenter",".featuredPost",stopFeaturedBanner);
	$("body").on("mouseleave",".featuredPost",startFeaturedBanner);
	
	$("body").on("click",".post .post-delete", deletePost);
	
	//$body.on("click",".file-display .delete", fileDelete);
});
/*
function fileDelete(){	
	re = confirm( "Are you sure you want to delete this image?" );
	if( !re ) return;	
}
*/
function deletePost( e ){	
	re = confirm( "Are you sure you want to delete this post?" );
	if( ! re  ){
		e.preventDefault();
	}
}

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
	//console.log( top_banner_data );
	if( top_banner_data.banner_count <= 1 ) return;
	if( top_banner_data.is_animating == true ) return;
	
	top_banner_data.is_animating = true;
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
	stopFrontBanner();	
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
	//console.log( data );
	//console.log( direction );
	$selector.animate({
		left: animation_movement
	}, speed, function(){		
		data.is_animating = false;
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
	if( $(window).width() < "980" ) return;
	subMenuTimeoutIn = setTimeout(function(){
		stopFrontBanner();
		$("#header-top .sub-menu").slideDown();
		autoScrollFeaturedBanner();
		/*suggested to start randommly each time the sub menu shows*/
		featured_banner_data.banner_current_page = Math.floor(Math.random() * featured_banner_data.banner_count) + 1  ;
		page_now = featured_banner_data.banner_current_page;		
		clicked_page = parseInt( page_now ) + 1;		
		featured_banner_data.banner_current_page = clicked_page;
		page_diff = page_now - clicked_page;
		if( clicked_page > featured_banner_data.banner_count ) clicked_page = 1;
		$(".featuredPost .page-navigator .page-item.is-active").removeClass("is-active");
		$(".featuredPost .page-navigator .page-item[page='" + clicked_page + "']").addClass("is-active");
		
		$selector = $(".featuredPost > .inner");
		animation_movement = ( page_now - page_diff ) * 100;
		do_banner_animation( "-" + animation_movement + "%", $selector, 0, 'right', featured_banner_data );
	},200);
}

function closeSubMenus(){
	clearTimeout( subMenuTimeoutIn );
	startFrontBanner();
	subMenuTimeoutOut = setTimeout(function(){		
		$("#header-top .sub-menu").slideUp();
		stopFeaturedBanner();
	},200);
}

function onResizeWindow(){
	difference_x = ( $(window).width() - 960 ) / 2 + 10;
	difference_y = ( $(".front-top-banner").height()/2 - $(".front-top-banner .arrow").height() + 4  );
	if( difference_x < 10 ) difference_x = 10;
	console.log( difference_y );
	if( difference_y <= 0 ) {
		setTimeout( function(){onResizeWindow()},100 );
	}
	else{
		$(".front-top-banner .arrow[direction='left']").css("left",difference_x).css("top",difference_y);
		$(".front-top-banner .arrow[direction='right']").css("right",difference_x).css("top",difference_y);
	}
	
}

function featuredPostAnimation(){
	$this = $(this);	
	
	if( featured_banner_data.is_animating == true ) return;
	
	featured_banner_data.is_animating = true;
	
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
	stopFeaturedBanner();
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






//var url_server_app = 'http://han.com/app/';//

/*pop up image*/
$(function(){
	$("body").on("click",".display-files .image, .modal-image", modal_window_image);
	//this function will not be compatible if the shown images are limited...
	$("body").on("click",".modal_image .arrow", change_modal_window_image);
	$("body").on("click",".modal_window", remove_modal_window);
	
	$(window).resize( callbackWindowResize );
});

function callbackWindowResize(){
	adjustModalImage( true );
}

function modal_window_image(){
	$this = $(this);
	//alert( $this.prev().attr('idx') );

	appendModalWindowToBody();
	
	data = {};
	data.action = 'modalImage';
	data.idx = $this.attr('idx');
	
	ajax_get_modal_window_data( data );
}

function change_modal_window_image(){
	$this = $(this);
	idx = $this.attr('idx');
	
	if( $(".modal_image[idx='" + idx + "']").length ){
		$(".modal_image").hide();
		$(".modal_image[idx='" + idx + "']").show();
	}
	else{
		data = {};
		data.action = 'modalImage';
		data.idx = $this.attr('idx');	
		ajax_get_modal_window_data( data );
	}
}

function ajax_get_modal_window_data( data ){
	var url = url_server_app + "modalWindow";
	$.ajax({
        'url': url,
        'data' : data
    })
	.done(function(html) {
		$(".modal_image").hide().removeClass('latest');
		$('.modal_window > .inner').append( $(html).addClass('latest') );
		adjustModalImage();
	})
	.fail(function() {
	  
	});
}

function adjustModalImage( adjustMode ){
	var $selector = $('.modal_window .modal_image.latest .image');	
	
	if( ! adjustMode ){
		$selector.hide();
		$selector.load(function(){
			doImageAdjust();
		});
	}
	else{
		doImageAdjust();
	}
}

function doImageAdjust(){
	var $selector = $('.modal_window .modal_image.latest .image');
	var window_width = $(window).width();
	var window_height = $(window).height();
	
	//$selector.css('width','100%');
	if( $selector.height() >= $selector.width() ) {				
		$selector.css('width','initial').css('height',$(window).height()-100);			
		if( $selector.width() > $(window).width() ) $selector.css('max-width','100%').css('height','initial');		
	}
	if( $selector.width() >= $selector.height() ){
		$selector.css('height','initial').css('max-width','100%');
		if( $selector.height() > $(window).height() ) $selector.css('height', ( $(window).height() - 100 ) ).css('width','initial');		
	}
	
	var margin_top = window_height/2 - $selector.height()/2 - 45;

	if( margin_top < 0 ) margin_top = 0;
	$selector.parent().css('margin-top',margin_top);//compatible for $(".modal_widow > .modal_image > img")
	
	$selector.show();
}

function appendModalWindowToBody(){
	$("body").append("<div class='modal_window'><div class='inner'></div></div>");
	$("body").css('overflow','hidden');
	document.ontouchmove = function(e){ e.preventDefault(); }//disable mobile scrolling
}

function appendModalWindowLoader(){
	html = "<div class='loader'><img src='" + url_server + "/module/app/img/loader8.gif" + "'></div>";	
	$('.modal_window').append(html);
}

function remove_modal_window( e ){
	
	//var target_class = $(e.target).attr('class');
	//console.log( target_class );
	//if( target_class == 'modal_window' || target_class == 'modal_image' ){
	if( $(e.target).hasClass('arrow') ){
		
	}
	else{
		$('.modal_window').remove();
		$("body").css('overflow','initial');
		document.ontouchmove = function(e){}//remove the disabled mobile scrolling
	}
}
/*eo pop up image*/