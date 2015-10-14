$(function(){
    var $menu = $('#panel-menu');
    $( "body" ).click(function( event ) {
        var $obj = $(event.target);
        if ( $obj.prop('class') == 'show-panel' || $obj.parent().prop('class') == 'show-panel') {

        }
        else closePanel();
    });
    $(".show-panel").click(togglePanel);
    $(".close-panel").click(closePanel);
    function togglePanel() {
        if ( $menu.css('display') == 'none' ) openPanel();
        else closePanel();
    }
    function closePanel() {
        $menu.hide();
    }
    function openPanel() {
        $menu.css({
            'right': 0 - $menu.width()
        });
        $menu.show();
        $menu.animate({
            'right': 0
        });
    }
});