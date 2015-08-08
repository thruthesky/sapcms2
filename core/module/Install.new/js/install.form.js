$(function(){

    $('#install-database-choce-1').click(function(){
        var $info = $('.mysql-information');
        var display = $info.css('display');
        if ( display != 'none' ) $info.hide();
    });

    $('#install-database-choce-2').click(function(){
        var $info = $('.mysql-information');
        var display = $info.css('display');
        if ( display == 'none' ) $info.show();
    });
});