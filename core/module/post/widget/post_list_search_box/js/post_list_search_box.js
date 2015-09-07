$(function(){
    $(".post-list-search-box [name='qn']").click(function(){
        if ( $(this).prop('checked') ) {
            $(".post-list-search-box [name='qt']").prop('checked', false);
            $(".post-list-search-box [name='qc']").prop('checked', false);
        }
    });
    $(".post-list-search-box [name='qt'],.post-list-search-box [name='qc']").click(function(){
        if ( $(this).prop('checked') ) {
            $(".post-list-search-box [name='qn']").prop('checked', false);
        }
    });
});