$(function(){
	$body = $("body");
	$body.on("click",".user-command.post-command .do-comment", focusCommentCursor );
});

function focusCommentCursor(){
	$this = $(this);
	$this.parents(".post").find(".comment-form-content").click();
	$this.parents(".post").find(".comment-form-content").focus();
}