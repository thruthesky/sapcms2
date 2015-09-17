$(function(){
    /**
     *
     */
    if ( typeof idx_comment != 'undefined' && idx_comment ) {
        setTimeout(function(){
            document.getElementById('comment' + idx_comment).scrollIntoView();
        }, 250);
    }		
});

function confirmDeletePost( e ){
	return confirm( "Are you sure you want to delete - "+e+"?" );
}

