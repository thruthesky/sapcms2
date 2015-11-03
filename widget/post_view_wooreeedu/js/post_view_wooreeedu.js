$ = jQuery;

$(function(){
	$("body").on("click",".post-view.wooreeedu .comments", focusOnCommentBox );
});

function focusOnCommentBox(){
	$selector = $(".post-view.wooreeedu .comment-form.wooreeedu:first textarea");
	$selector.focus();
	autoScroll = $selector.offset().top - 100;
	console.log( autoScroll );
	$("body,html").animate({
		"scrollTop":autoScroll
	},
		500,
		function(){
			
		}
	);
}