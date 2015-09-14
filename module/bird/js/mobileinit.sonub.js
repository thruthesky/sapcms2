$(document).bind("mobileinit", function(){
    $.mobile.page.prototype.options.domCache = false;
    $.mobile.ajaxEnabled = false;
});