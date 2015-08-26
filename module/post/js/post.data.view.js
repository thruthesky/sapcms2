$(function(){
    if ( typeof idx_comment != 'undefined' && idx_comment ) {
        setTimeout(function(){
            document.getElementById('comment' + idx_comment).scrollIntoView();
        }, 250);

    }
});