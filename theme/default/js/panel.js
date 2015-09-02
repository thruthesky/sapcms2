$(function(){

    $(".show-panel").click(function() {
        var $menu = $('#panel-menu');
        $menu.css({
            'right': 0 - $menu.width()
        });
        $menu.show();
        $menu.animate({
            'right': 0
        });
    });
    $(".close-panel").click(function() {
        var $menu = $('#panel-menu');
        $menu.hide();
    });
});