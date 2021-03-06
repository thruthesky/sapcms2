$ = jQuery;
$(function(){
	$("body").on("click",".graph-wrapper .bar-wrapper", show_graph_commands);
	$("body").on("change","select[name='show_by']", change_date_type);	
	
	$("body").click( hide_graph_commands );
});

var $graph_mouseenter_timeout;
var $graph_mouseleave_timeout;
var $old_index;

function show_graph_commands( e ){
	//just temporary 
	if( $( e.target ).hasClass("custom_title") ) return;
	if( $( e.target ).parent().hasClass("custom_title") ) return;

	$this = $(this);
	if( $this.find(".custom_title.is-active").hasClass("is-active") ){
		console.log($this.prop('class'));
		$this.removeClass('is-active');
		$this.find(".custom_title.is-active").removeClass("is-active");
		return;
	}
	else{
		$(".graph-wrapper .bar-wrapper.is-active").find(".custom_title.is-active").removeClass("is-active");
		$(".graph-wrapper .bar-wrapper.is-active").removeClass("is-active");		
	}
	
	$this.addClass("is-active");	
	
	/*for left of right position*/
	x = e.pageX;
	x_diff = $(window).width() - x - 25;//30 = constant
	custom_title_width = $this.find(".custom_title").width() + 25;
	
	x_position = $this.width();

	if( custom_title_width > x_diff ){
		$this.find(".custom_title").css( "right", x_position + "px" );
		$this.find(".triangle.outer ").css( "right", "-5px" );
		$this.find(".triangle.inner ").css( "right", "-4px" );
		$this.find(".triangle.outer ").css( "border-left", "5px solid #777" );
		$this.find(".triangle.inner ").css( "border-left", "5px solid #fff" );
	}
	else{
		$this.find(".custom_title").css( "left", x_position + "px" );
		$this.find(".triangle.outer ").css( "left", "-5px" );
		$this.find(".triangle.inner ").css( "left", "-4px" );
		$this.find(".triangle.outer ").css( "border-right", "5px solid #777" );
		$this.find(".triangle.inner ").css( "border-right", "5px solid #fff" );
		
	}
	/*eo for left of right position*/
	y = e.pageY;
	$graph_wrapper = $(".graph-wrapper").offset().top;
	y_position = y - $graph_wrapper - 30;
	$this.find(".custom_title").css( "top", y_position + "px" ).addClass("is-active");
}

function hide_graph_commands( e ){
	if( $(".graph-wrapper .bar-wrapper.is-active").length ){		
		if( $( e.target ).parents(".bar-wrapper").length || $( e.target ).hasClass('bar-wrapper') ){
		}	
		else{			
			$(".graph-wrapper .bar-wrapper.is-active").find(".custom_title.is-active").removeClass("is-active");
			$(".graph-wrapper .bar-wrapper.is-active").removeClass("is-active");
		}
	}
}

function change_date_type(){
	$this = $(this);
	$("input[name='date_from']").val('');
	$("input[name='date_to']").val('');
}