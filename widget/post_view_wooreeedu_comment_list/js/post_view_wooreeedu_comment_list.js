$(function(){
    $(".reply-button").click(function(){
        //$(this).next().show();
		$this = $(this);
		$this.parents('.comment').find(".comment-form:first").show();
    });
});