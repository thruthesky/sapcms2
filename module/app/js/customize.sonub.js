
function showLoader() {
    var src = 'http://sapcms2.org/theme/default/tmp/s.png';
    var $body = $('body');
    var $document = $(window);
    $body.append("<div class='loader'><img src='"+src+"'> 소너브 로딩중입니다.</div>");

    var $loader = $('.loader');
    var body_width = $document.width();
    var loader_width = $loader.width();

    var body_height = $document.height();
    var loader_height = $loader.height();

    $loader.css({
        'left' : (body_width / 2 - loader_width / 2) - 20,
        'top' :  (body_height / 2 - loader_height / 2) - 20
    });

    console.log("show loader");
}
function hideLoader() {
    setTimeout(function(){
        $('.loader').remove();
    }, 800);
    console.log("hide loader");
}