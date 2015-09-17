/**
 *
 *
 */
var url_server_app = url_server + '/app/';
var url_server_post_comment_submit = url_server + '/app/post/comment/submit';
var currentPageID = 'local-page';
var prevPageID = 'local-page';
var $session_id = null;
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

    $session_id = getSessionId();
    console.log("session_id:" + $session_id);

    //setTimeout(callback_offline, 2000);
    //setTimeout(callback_online, 4000);
    initialize();
    loadPage('front_page');
    //loadPage('postList', 'test');
    //loadPage('login');
});

function moveToFrontPage() {
    loadPage('front_page');
}

function initialize() {
    initMenu();
    initPanel();
}

function initMenu() {
    var $body = $('body');
    $body.on('click', ".link", function() {
        var $this = $(this);
        var route = $this.attr('route');
        console.log('route:' + route)
        var url;
        if ( url = $this.attr('url') ) {
            console.log('rel local');
            location.href=url;
        }
        else if ( route == 'postList' ) {
            loadPage( route, $this.attr('post_id'));
        }
        else {
            loadPage(route);
        }
    });
    $body.on('click', '#panel-menu .logout', function(){
        setSessionId('');
        moveToFrontPage();
        alert('로그아웃을 하였습니다.');
    });
}

function initPanel() {
    function getMenu() {
        return $('#panel-menu');
    }
    var $body = $('body');

    /**
     * @note It is very difficult when it comes to finger touch.
    $body.on('click', '*', function( event ) {
        //console.log('body click');
        var $obj = $(event.target);
        //console.log( "target object: " + $obj.prop('class'));
        if ( $obj.prop('class') == 'show-panel' || $obj.parent().prop('class') == 'show-panel') {

        }
        else closePanel();
    });
    */

    //$body.on('click', ".show-panel", togglePanel);

    $body.on('click', ".show-panel", openPanel);
    $body.on('click', ".close-panel", closePanel);
    /*
    function togglePanel() {
        if ( getMenu().css('display') == 'none' ) openPanel();
        else closePanel();
    }
    */

    function isPanelOpen() {
        return getMenu().css('display') != 'none';
    }
    function closePanel() {
        var $menu = getMenu();
        if ( getMenu().css('display') == 'none' ) return;
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
        if ( isPanelOpen() ) return;
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

function showPage(id, html) {
    prevPageID = currentPageID;
    currentPageID = id;
    $('#' + prevPageID).remove();
    $('body').append(html);
    console.log("prevPageID:" + prevPageID);
    console.log("currentPageID:" + currentPageID);
    hideLoader();
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
    console.log("loadPage( "+route+", "+post_id+" )");
    if ( currentPageID == route ) {
        console.log("Trying to open same page? ... It loads anyway.");
    }
    var url = url_server_app + route;
    if ( post_id ) url += '/' + post_id;
    console.log("open: " + url);
    showLoader();
    $.ajax({
        'url': url,
        'data' : { 'session_login': $session_id }
    })
        .done(function(html) {
            showPage(route, html);
        })
        .fail(function() {
            console.log("loading " + url + " ... failed...!");
        });
}



/***************************** F I L E   U P L O A D */
var isUploadSubmit = false;
var file_upload_form_name = null; // last upload form file name
function onFileChange(obj) {
    file_upload_form_name = $(obj).prop('name');
    var $form = $(obj).parents("form");
    isUploadSubmit = true;
    $form.submit();
    isUploadSubmit = false;
    $(obj).val('');
}
function fileDelete(idx) {
    $.ajax("/file/delete?idx="+idx)
        .done(function(re){
            try {
                var re = JSON.parse(re);
                if ( re.error ) alert( re.message );
                else {
                    console.log("idx: " + idx + " deleted");
                    $('.file[idx="'+re.idx+'"]').remove();
                }
            }
            catch (e) {
                alert(re);
            }
        })
        .fail(function(){
            console.log('failed to load');
        });
}
$(function(){
    var $body = $('body');
    $body.on("click",".file-display .delete", function(){
        var idx = $(this).parent().attr('idx');
        //console.log("why man call ? " + idx);
        fileDelete(idx);
    });
    $body.on('submit', '.ajax-file-upload', function(){
        var $this = $(this);
        if ( isUploadSubmit == false ) {
            ajaxCommentSubmit($this);
            return false;
        }
        console.log("form: "+ $this.find("[name='idx_parent']").val());
        var $progressBar = $this.find(".ajax-file-upload-progress-bar");
        var lastAction = $this.prop('action');
        $this.prop('action', url_server+'/file/upload');
        $this.ajaxSubmit({
            beforeSend: function() {
                console.log("bseforeSend:");
                showProgressBar();
            },
            uploadProgress: function(event, position, total, percentComplete) {
                //console.log("while uploadProgress:" + percentComplete + '%');
                setProgressBar( percentComplete + '%');
            },
            success: function() {
                console.log("upload success:");
                setProgressBar( '100%');
                setTimeout(function(){
                    hideProgressBar();
                }, 150);
            },
            complete: function(xhr) {
                console.log("Upload completed!!");
                var re;
                try {
                    re = JSON.parse(xhr.responseText);
                }
                catch ( e ) {
                    return alert( xhr.responseText );
                }

                console.log(re);

                fileDisplay($this, re);
                fileCallback(re);
                setFid(re);

            }
        });
        function fileCallback(re) {
            var callback = $this.find('[name="file_callback"]').val();
            if ( callback ) window[callback](re);
        }

        function showProgressBar() {
            var markup = "<div class='graph'>0%</div>";
            $progressBar.html(markup).show();
        }
        function hideProgressBar() {
            $progressBar.html('').hide();
        }
        function setProgressBar(percent) {
            $progressBar.find('.graph')
                .width(percent)
                .html(percent);
        }
        function setFid(re) {
            var $fid = $this.find("[name='fid']");
            var val = $fid.val();
            for ( var i in re ) {
                val += ',' + re[i].idx;
            }
            $fid.val(val);
        }

        $this.prop('action', lastAction);
        return false;
    });
});


/**
 *
 * @param $this - the FORM object
 * @param re - Object of file information array
 *  0: Object
 *      error: - if there is any error.
 *      form_name:
 *      idx: - is idx of file
 *      name: - is the file name
 *      type -
 *      url -
 *
 */
function fileDisplay($this, re) {
    if ( typeof re == 'undefined' || ! re ) return;
    var display = $this.find('[name="file_display"]').val();
    if ( display ) {
        var form_name = re[0].form_name;
        var $display = $this.find(".file-display." + form_name);
        if ( $display.length == 0 ) {
            $this.find("[name^='"+form_name+"']").after("<div class='file-display "+form_name+"'></div>");
            $display = $this.find(".file-display." + form_name);
        }
        for ( var i in re ) {
            var file = re[i];
            if ( file.error ) {
                alert(file.message);
            }
            else {
                var markup = "<div idx='"+file.idx+"' class='file";
                if ( file.mime.indexOf('image') != -1 ) {
                    markup += " image'>";
                    markup += "<img src='"+file.url+"'>";
                }
                else {
                    markup += " attachment'>";
                    markup += file.name;
                }
                markup += "<div class='delete' title='Delete this file'>X</div>";
                markup += "</div>";
                $display.append(markup);
            }
        }
    }
}

/****** COMMENT FORM */
$(function(){
    $("body").on("click", ".comment-reply-button", function(){
        $(this).parent().find('.comment-form').show();
    });
    $(".comment-form-content").keydown(function(e) {
        if ( e.which == 13 ) {
            var $this = $(this);
            var no = $this.parents('form').attr('no');
            console.log('no:'+no);
            if ( typeof countEnter[no] == 'undefined' ) {
                countEnter[no] = 0;
            }
            countEnter[no] ++;
            console.log("counter:" + countEnter[no]);
            if ( countEnter[no] < 16 ) {
                $this.css('height', $this.height()+24);
                //console.log("height:"+$this.height());
            }
        }
    });
});

/****** COMMENT UPLOAD */
function ajaxCommentSubmit($this) {
    // alert($this.find('[name="content"]').val());
    $this.prop('action', url_server_post_comment_submit);
    $this.ajaxSubmit({
        type: 'post',
        success: function() {
            console.log("post success:");
        },
        complete: function(xhr) {
            console.log("post comment submit completed!!");
            var re = xhr.responseText;
            //console.log(re);
            //var idx = $this.parents('.comment').attr('idx');
            //console.log(idx);
			$comment_depth = $(re).attr('depth');
			if( $comment_depth > 1 ){
				$parent = $this.parents('.comment');
				$parent.after( $(re) );//.html(re);
			}
			else {
				$parent = $this.parents('.post').find('.comments');
				$parent.prepend( $(re) );
			}
			
			//reset the comment box
			$this.find(".comment-form-content").val("");
			$this.find("input[name='fid']").val("");
			$this.find(".file-display.files").html("");
        }
    });
}



/** LOGIN */
$(function(){
    $("body").on('submit', "form.login", function(){
        var $this = $(this);
        var id = $this.find('[name="id"]').val();
        var password = $this.find('[name="password"]').val();
        var url = url_server_app + "loginSubmit?id=" + id + "&password=" + password;
        console.log("login url: " + url);
        $.ajax(url)
            .done(function(responseData){
                //console.log(re);
                try {
                    var re = $.parseJSON(responseData);
                    console.log(re);
                    if ( re.error ) alert("로그인 실패. 아이디와 비밀번호를 확인해 주세요.");
                    else {
                        setSessionId(re.session_id);
                        moveToFrontPage();
                    }
                }
                catch (e) {
                    alert(responseData);
                }
            })
            .fail(function(){
                //
            });
        return false;
    });
});



/** Session ID */
function getSessionId() {
    $session_id = sessionStorage.getItem("session_id");
    return $session_id;
}

function setSessionId($sid) {
    $session_id = $sid;
    sessionStorage.setItem("session_id", $sid);
}
/** EO Session ID */
