$(function(){
    /**
     *
     */
    if ( typeof idx_comment != 'undefined' && idx_comment ) {
        setTimeout(function(){
            document.getElementById('comment' + idx_comment).scrollIntoView();
        }, 250);
    }


    $("form[name='comment'] textarea").click(function(){
        $(this).parent().find(".show-on-click").show();
    });



});

