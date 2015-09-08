$ = jQuery;
$(function(){
	$("body").on("click",".graph-wrapper .bar-wrapper", show_graph_commands);	
	$("body").on("change","select[name='show_by']", change_date_type);	
});

var $graph_mouseenter_timeout;
var $graph_mouseleave_timeout;
var $old_index;

function show_graph_commands( e ){
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
	if( custom_title_width > x_diff ){
		$this.find(".custom_title").css( "right", "30px" );
		$this.find(".triangle.outer ").css( "right", "-5px" );
		$this.find(".triangle.inner ").css( "right", "-4px" );
		$this.find(".triangle.outer ").css( "border-left", "5px solid #777" );
		$this.find(".triangle.inner ").css( "border-left", "5px solid #fff" );
	}
	else{
		$this.find(".custom_title").css( "left", "25px" );
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

function hide_graph_commands(){
	$this = $(this);
	$this.parent().removeClass('is-active');
}

function change_date_type(){
	$this = $(this);
	$("input[name='date_from']").val('');
	$("input[name='date_to']").val('');
	
	$("input[name='date_from']").prop('type',$this.val());
	$("input[name='date_to']").prop('type',$this.val());
}