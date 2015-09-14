/**
 *
 *
 */

var url_page_create = 'http://sapcms2.org/bird/';

function callback_offline() {
    // setPageContentOffline();
    showOfflineMessage();
}

function callback_online() {
    hideOfflineMessage();
}

function callback_deviceReady() {
    console.log('callback_deviceReady');
}

$(function() {
    //setTimeout(callback_offline, 2000);
    //setTimeout(callback_online, 4000);
    initialize();
    //loadPage('front_page');
});

function initialize() {
    initMenu();
    initPanel();
}
function initMenu() {
    var $body = $('body');
    $body.on('click', ".link", function() {

        var $this = $(this);
        var route = $this.attr('route');
        if ( $this.attr('rel') ) {
            console.log('rel local');
            location.href='index.html';
        }
        else if ( route == 'postList' ) {
            loadPage( route, $this.attr('post_id'));
        }
        else {
            loadPage(route);
        }
    });
}

function initPanel() {
    function getMenu() {
        return $('#panel-menu');
    }
    var $body = $('body');
    $body.click(function( event ) {
        var $obj = $(event.target);
        if ( $obj.prop('class') == 'show-panel' || $obj.parent().prop('class') == 'show-panel') {

        }
        else closePanel();
    });
    $body.on('click', ".show-panel", togglePanel);
    $(".close-panel").click(closePanel);
    function togglePanel() {
        if ( getMenu().css('display') == 'none' ) openPanel();
        else closePanel();
    }
    function closePanel() {
        var $menu = getMenu();
        $menu.animate(
            {
                'right': -$menu.width()
            },
            function() {
                $menu.hide();
            }
        );
    }
    function openPanel() {
        var $menu = getMenu();
        $menu.css({
            'right': 0 - $menu.width()
        });
        $menu.show();
        $menu.animate({
            'right': 0
        });
    }
}

function showOfflineMessage() {
    var content = "<div class='offline'>오프라인. 인터넷에 연결 해 주세요.</div>";
    getCurrentPageContent().prepend(content);
}
function hideOfflineMessage() {
    $('.offline').remove();
}

function setPageContent(content) {
    console.log(content);
    $('#' + currentPageID + ' .ui-content').html(content);
}

/**
 *
 * @Warning Using "$.mobile.pageContainer.pagecontainer("getActivePage");" is not an appropriate because it applies much after it is actually inserted.
 *
 *
 * @returns {*|jQuery|HTMLElement}
 */
function getCurrentPage() {
    //var activePage = $.mobile.pageContainer.pagecontainer("getActivePage");
    //return activePage.find('.page');
    return $(".ui-page-active");
}
function getCurrentPageContent() {
    return getCurrentPage().find('.ui-content');
}

function showPage(id) {
    $.mobile.pageContainer.pagecontainer("change", '#' + id );
}

/**
 *
 *
 * setPage('offline');
 *
 * @param route
 * @param post_id
 */
function loadPage(route, post_id) {
    var url = url_page_create + route;
    if ( post_id ) url += '/' + post_id;
    console.log(url);
    $.ajax(url)
        .done(function(html) {
            $('body').append(html);
            $('#' + route).trigger('pagecreate');
            showPage(route);
        })
        .fail(function() {
            console.log("loading " + url + " ... failed...!");
        });
}
