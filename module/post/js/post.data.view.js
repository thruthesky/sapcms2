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


var LastCKEditor;
var CKEditorArray = [];
function loadCKEditor(id) {
    LastCKEditor = CKEDITOR.replace( id, {
        uiColor: '#f9f9f9',
        startupFocus : true,
        height:'12em',
        toolbar :
            [
                [
                    'Bold', 'Italic', 'Underline', 'Strike', "TextColor", "BGColor",
                    'NumberedList', 'BulletedList',
                    'Cut', 'Copy', 'Paste', 'Undo', 'Redo',
                    "Blockquote", "Link", "Unlink", 'HorizontalRule',
                    "Table",
                    "Smiley",
                    'Source',
                    "Maximize",
                    'FontSize', 'Format'
                ]
            ]
    } );

    CKEditorArray[id] = LastCKEditor;

    CKEDITOR.on("instanceReady", function(event) {
        var range = LastCKEditor.createRange();
        range.moveToElementEditablePosition( LastCKEditor.editable(), true );
        LastCKEditor.getSelection().selectRanges( [ range ] );
    });
}
function loadReplyCKEditor(id) {
    $(".show-on-click").show();
    loadCKEditor(id);
}
function loadCommentCKEditor(id) {
    $("#"+id).parent().show();
    loadCKEditor(id);
}