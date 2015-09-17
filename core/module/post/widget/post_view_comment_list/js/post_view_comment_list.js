$(function(){
    $(".reply-button").click(function(){
        $(this).parents(".comment").find('.comment-form').show();
        $(this).parents(".comment").find('.comment-form textarea').click();
        $(this).parents(".comment").find('.comment-form textarea').focus();
    });	
});