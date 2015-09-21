/**
 *
 *
 */
var url_server_app = url_server + '/app/';
var url_server_post_submit = url_server + '/app/post/submit';
var url_server_post_comment_submit = url_server + '/app/post/comment/submit';
var url_server_post_edit_submit = url_server + '/app/post/edit/submit';
var url_server_post_edit_comment_submit = url_server + '/app/post/edit/comment/submit';
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
    appStarted = true;
    $session_id = getSessionId();
    console.log("session_id:" + $session_id);

    initializeEvent();
    initializeMenu();

    //setTimeout(callback_offline, 2000);
    //setTimeout(callback_online, 4000);
    //loadPage('front_page');
    loadPage('register');
    //loadPage('postList', 'test');
    //loadPage('login');
    //loadPage('profile');
    //loadPage('postList', 'test');

    //scrollListener();
});

function moveToFrontPage() {
    loadPage('front_page');
}

function initializeEvent() {
    var $body = $('body');
    $body.on('click', ".take-user-primary-photo", cameraUserPrimaryPhoto);
    $body.on('click', ".post-file-upload-button", cameraPostFile);
    $body.on('submit', "form[name='register']", registerSubmit);
    $body.on('submit', "form[name='profileUpdate']", profileUpdateSubmit);
}

function initializeMenu() {
    initMenu();
    initPanel();
}

function initMenu() {
    var $body = $('body');
    $body.on('click', ".link", function() {
        var $this = $(this);
        var route = $this.attr('route');
        console.log('route:' + route);
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
        loadPage('logout');
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



function registerSubmit(event) {
    var $form = $(this);
    var url = url_server_app + "registerSubmit";
    $.ajax({
        type: 'get',
        url: url,
        data: $form.serialize()
    }).done(function(data){
        console.log(data);
        try {
            var re = JSON.parse(data);
            if ( re.error ) return message(re.error);
            else {
                setSessionId(re.session_id);
                moveToFrontPage();
            }
        }
        catch (e) {
            console.log(data);
        }
    }).fail(function(data){
        alert(data);
    });
    event.preventDefault();
    return false;
}

function profileUpdateSubmit() {
    var $form = $(this);
    var url = url_server_app + "profileUpdateSubmit";
    $.ajax({
        type: 'get',
        url: url,
        data: $form.serialize()
    }).done(function(data){
        try {
            var re = JSON.parse(data);
            if ( re.error != 0 ) return message(re.error);
            else {
                message(textUpdateProfile());
            }
        }
        catch (e) {
            alert(data);
        }

    }).fail(function(data){
        console.log('error');
        console.log(data);
    });
    event.preventDefault();
    return false;
}

function showOfflineMessage() {
    var content = "<div class='offline'>오프라인. 인터넷에 연결 해 주세요.</div>";
    getCurrentPageContent().prepend(content);
}
function hideOfflineMessage() {
    $('.offline').remove();
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
    //$('#' + prevPageID).remove();
    $(".page").remove();
    $('body').append(html);
    $(window).scrollTop(0);
    beginEndLessPage();
    /*
    console.log("prevPageID:" + prevPageID);
    console.log("currentPageID:" + currentPageID);
    */
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
        'data' : { 'session_login': $session_id, 'post_id': post_id }
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
        .done(function(data){
            try {
                var re = JSON.parse(data);
                if ( re.error ) alert( re.message );
                else {
                    console.log("idx: " + idx + " deleted");
                    $('.file[idx="'+re.idx+'"]').remove();
                }
            }
            catch (e) {
                alert(data);
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
			data : { 'session_login': $session_id },
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
    $("body").on("click","form[name='comment']", function(){
        var $this = $(this);
        
        $this.find('textarea').css('height', '35');
        $this.find('.post-file-upload-button').css('padding', '11px 8px');
    });

    $("body").on("click", ".comment-reply-button", function(){
        $(this).parents(".comment").find('.comment-form').show();
        $(this).parents(".comment").find('.comment-form textarea').focus();
    });
	
	
	var countEnter = [];
    $("body").on("keydown",".comment-form-content, .post-form-content",function(e) {
		console.log("KEYDOWN");
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
	var upload_type;
	if( $this.hasClass('comment-edit') ){
		upload_type = 'comment_edit';
		$this.prop('action', url_server_post_edit_comment_submit);		
	}
	else if( $this.hasClass('edit') ){
		upload_type = 'post_edit';
		$this.prop('action', url_server_post_edit_submit);		
	}
	else if( $this.hasClass('post-form') ){
		upload_type = 'post';
		$this.prop('action', url_server_post_submit);
	}
    else {
		upload_type = 'comment'
		$this.prop('action', url_server_post_comment_submit);
	}
	
    $this.ajaxSubmit({
        type: 'post',
		data : { 'session_login': $session_id },
        success: function() {
            console.log("post success:");
        },
        complete: function(xhr) {
            console.log("post comment submit completed!!");
            var re = xhr.responseText;
            console.log("re:");
            console.log(re);
            //var idx = $this.parents('.comment').attr('idx');
            //console.log(idx);
			if( upload_type == 'comment_edit' ) post_edit_comment_html_ajax( re, $this );
			else if( upload_type == 'post_edit' ) post_edit_html_ajax( re, $this );
			else if( upload_type == 'comment' ) comment_html_ajax( re, $this );
			else if( upload_type = 'post' ) post_html_ajax( re, $this );
        }
    });
}

function post_html_ajax( re, $this ){
	$this.after( $(re) );
	//reset the comment box
	$this.find(".post-form-content").val("");
	$this.find("input[name='fid']").val("");
	$this.find(".file-display.files").html("");
}

function comment_html_ajax( re, $this ){
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
	//console.log( $this.attr("class") );
	if( $(re).attr('depth') > 1 ) $this.parent().hide();
	$this.find(".comment-form-content").val("");
	$this.find("input[name='fid']").val("");
	$this.find(".file-display.files").html("");
}

/*delete*/
$(function(){
	$("body").on( "click", "span.delete", ajaxPostDelete );
});

function ajaxPostDelete(){
	$this = $(this)
	idx = $this.attr("idx");
	url = url_server + "/app/delete?idx=" + idx + "&session_login=" + $session_id;
	$.ajax(url)
            .done(function(re){
                //console.log(re);
                try {
					$html = $(re).find(".post").html();
					if( ! $html ) $this.parents(".post").remove();
					else $this.parents(".post").html( $html );			
                }
                catch (e) {
					alert( "Error! [ code here ] [ message here ]" );
                }
            })
            .fail(function(){
                alert( "Fail! [ code here ] [ message here ]" );
            });
}
/*eo delete*/

/*edit*/
$(function(){
	$("body").on( "click", "span.edit.is-post", ajaxPostGetEditForm );
	$("body").on( "click", "span.edit.is-comment", ajaxPostGetCommentEditForm );
	//$("body").on( "click", "span.edit", ajaxPostEditSubmit );
});

function ajaxPostGetEditForm(){
	$this = $(this)
	idx = $this.attr("idx");
	url = url_server + "/app/getPostEditForm?idx=" + idx + "&session_login=" + $session_id;
	
	$.ajax(url)
            .done(function(re){
                //console.log(re);
                try {
					if( $this.parents(".post").find("form.ajax-file-upload.post-form.edit").length ) return;
					$this.parents(".post").find(".content:first").hide();
					$this.parents(".post").find(".content:first").after( re );
					$this.parents(".post").find("textarea:first").select();
                }
                catch (e) {
					alert( "Error! [ code here ] [ message here ]" );
                }
            })
            .fail(function(){
                alert( "Fail! [ code here ] [ message here ]" );
            });
}

function ajaxPostGetCommentEditForm(){	
	$this = $(this)
	idx = $this.attr("idx");
	url = url_server + "/app/getPostCommentEditForm?idx=" + idx + "&session_login=" + $session_id;
	console.log( url );
	$.ajax(url)
            .done(function(re){
                try {					
					if( $this.parents(".comment").find("form.ajax-file-upload.comment-edit").length ) return;
					$this.parents(".comment").find(".content").hide();					
					$this.parents(".comment").find(".content").after( re );					
					$this.parents(".comment").find("textarea:first").select();
                }
                catch (e) {
					alert( "Error! [ code here ] [ message here ]" );
                }
            })
            .fail(function(){
                alert( "Fail! [ code here ] [ message here ]" );
            });
}

function post_edit_html_ajax( re, $this ){
	$this.parents(".post").find(".content:first").html( re ).show();
	$this.parents(".post").find(".edit-files").remove();
	$this.remove();
}

function post_edit_comment_html_ajax( re, $this ){
	$this.parents(".comment").find(".content:first").html( re ).show();
	$this.parents(".comment").find(".edit-files").remove();
	$this.remove();
}
/*eo edit*/

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


/*VOTE*/

$(function(){
	$("body").on("click", ".vote > div", function() {
	var $this = $(this);
	var $vote = $this.parent();
	var url = url_server + "/post/vote/" + $this.prop('class') + "/" + $vote.attr('idx') + "?session_login=" + $session_id;
	console.log("vote url: " + url);
	$.ajax(url)
		.done(function(data){
			var re = JSON.parse(data);
			console.log(re);
			if ( re.error ) {
				alert(re.message);
			}
			else {
				$(".vote[idx='"+re.idx+"'] ." + re.type + ' .no').text(re.no);
			}
		})
		.fail(function(data) {
			console.log(re);
		});
	});
});
/*EO VOTE*/

/*edit file-delete*/
$(function(){
	$("body").on("click",".edit-files .delete",editFileDelete);
});

function editFileDelete(){
	$this = $(this);
	idx = $this.parent().attr("idx");
	url = url_server + "/file/delete?idx="+idx+"&session_login="+$session_id;
	console.log( url );
	$.ajax( url )
        .done(function(re){
            try {
                $this.parent().remove();
            }
            catch (e) {
                
            }
        })
        .fail(function(){
            console.log('failed to load');
        });
}
/*EO edit file-delete*/

/* COMMANDS */
$(function(){	
	$("body").on("click",".user-command.post-command .do-comment", focusCommentCursor );
});

function focusCommentCursor(){
	$this = $(this);
	$this.parents(".post").find(".comment-form-content").click();
	$this.parents(".post").find(".comment-form-content").focus();
}
/* EO COMMANDS */



/** M e s s a g e */
function message(msg) {

    navigator.notification.alert(
        msg,  // message
        null,         // callback
        getMessageTitle(),            // title
        getMessageButton()                  // buttonName
    );
}
function getMessageTitle() {
    if ( typeof text_messageTitle == 'function'  ) return text_messageTitle();
    else return '제목';
}
function getMessageButton() {
    if ( typeof text_messageButton == 'function'  ) return text_messageButton();
    else return '확인';
}
function getNoMoreContent() {
    if ( typeof text_noMoreContent == 'function'  ) return text_noMoreContent();
    else return 'No more content';
}
function textUpdateProfile() {
    if ( typeof text_updateProfile == 'function'  ) return text_updateProfile();
    else return 'Profile has been updated';
}
/* EO Message */


/** C a m e r a */

var photoOptions = {};

function setPhotoSelector(selector, add) {
    photoOptions.selector = selector;
    photoOptions.add = add;
}
function setFileInfo(module, type, idx_target, finish, unique, image_thumbnail_width, image_thumbnail_height, callback) {
    photoOptions.module = module;
    photoOptions.type = type;
    photoOptions.idx_target = idx_target;
    photoOptions.finish = finish;
    photoOptions.unique = unique;
    photoOptions.image_thumbnail_width = image_thumbnail_width;
    photoOptions.image_thumbnail_height = image_thumbnail_height;
    photoOptions.callback = callback;
}

function onCameraConfirm(no) {
    var type = 0;
    if ( no == 1 ) {
        type = Camera.PictureSourceType.CAMERA;
    }
    else if ( no == 2 ) {
        type = Camera.PictureSourceType.PHOTOLIBRARY;
    }
    else return;
    setTimeout(function() {
        navigator.camera.getPicture( cameraSuccess, cameraError, {
            'quality' : 100,
            'sourceType' : type,
            'destinationType': Camera.DestinationType.FILE_URI
        } );
    },  0);
}




function clearCache() {
    navigator.camera.cleanup();
}
var retries = 0;
function cameraSuccess(fileURI) {
    var win = function (r) {
        console.log("Code = " + r.responseCode);
        console.log("Response = " + r.response);
        console.log("Sent = " + r.bytesSent);
        var data = r.response;

        clearCache();
        retries = 0;
        var re = JSON.parse(data);
        for ( var i in re ) {
            var file = re[i];
            if ( file.error ) {
                alert(file.message);
            }
            if ( photoOptions.add ) $(photoOptions.selector).append("<img src='"+file.urlThumbnail+"'>");
            else $(photoOptions.selector).html("<img src='"+file.urlThumbnail+"'>");

            if ( typeof photoOptions.callback == 'function' ) photoOptions.callback(file);
        }
    };

    var fail = function (error) {
        if (retries == 0) {
            retries ++;
            setTimeout(function() {
                cameraSuccess(fileURI);
            }, 1000);
        } else {
            retries = 0;
            clearCache();
            message('실패! 업로드하지 못하였습니다.');
            console.log("An error has occurred: Code = " + error.code);
            console.log("upload error source " + error.source);
            console.log("upload error target " + error.target);
        }
    };

    var options = new FileUploadOptions();
    options.fileKey = "file";
    options.fileName = fileURI.substr(fileURI.lastIndexOf('/') + 1);
    options.mimeType = "image/jpeg";
    options.params = {
        'file_module': photoOptions.module,
        'file_type': photoOptions.type,
        'file_idx_target': photoOptions.idx_target,
        'file_finish': photoOptions.finish,
        'file_unique': photoOptions.unique,
        'file_image_thumbnail_width': photoOptions.image_thumbnail_width,
        'file_image_thumbnail_height':  photoOptions.image_thumbnail_height
    };
    console.log(options);
    var ft = new FileTransfer();
    var url = url_server + '/file/upload';
    console.log(url);
    ft.upload(fileURI, encodeURI(url), win, fail, options);
}

function cameraError(msg) {
    message(msg);
}

function takePhotoUpload() {
    navigator.notification.confirm(
        '사진을 찍으시겠습니까? 갤러리에서 선택하시겠습니까?', // message
        onCameraConfirm,            // callback to invoke with index of button pressed
        '사진 올리기',           // title
        ['사진 찍기','사전 선택', '취소']     // buttonLabels
    );
}
/* EO Camera */



/** User primary photo */
function cameraUserPrimaryPhoto() {
    setPhotoSelector('.user-primary-photo', false);
    setFileInfo('user', 'primary_photo', 0, 1, 1, 140, 140);
    takePhotoUpload();
}
/** Post file uplod */
function cameraPostFile() {
    //alert('hi');
    var $this = $(this);
    var $form = $this.parents('form');
    var idx = $form.find('[name="idx_parent"]').val();
    var no = $form.attr('no');
    var selector = 'form[no="'+no+'"] .file-display';
    console.log(selector);
    setPhotoSelector(selector, true);
    setFileInfo('post', 'files', idx, 0, 0, 140, 140, callback_post_file_upload);
    takePhotoUpload();
}
function callback_post_file_upload(file) {
    var $display = $(photoOptions.selector);
    var $form = $display.parents('form');
    var $fid = $form.find("[name='fid']");
    var val = $fid.val() + ',' + file.idx;
    $fid.val(val);
}

/** Endless Scroll */
/**
 *
 *
 */
var iScrollCont = 0;
var bEndLessInLoading = false;
var bNoMoreContent = false;
var iTimerEndless = 0;
function beginEndLessPage() {
    endEndLessPage();
    var $page = $(".page");
    if ( $page.attr('route') == 'postList' || $page.attr('route') == 'front_page' ) {
        scrollListenerForEndLessPage(callback_endless, 150, 250);
        showEndlessPageLoader();
    }
}
function endEndLessPage() {
    clearEndlessPage();
    clearInterval(iTimerEndless);
}
function scrollListenerForEndLessPage(callback, distance, interval) {
    var $window = $(window),
        $document = $(document);
    var checkScrollPosition = function() {
        if ( bEndLessInLoading ) return;
        var top = $document.height() - $window.height() - distance;
        if ($window.scrollTop() >= top) {
            iScrollCont++;
            console.log("count:" + iScrollCont);
            callback(iScrollCont);
        }
    };
    iTimerEndless = setInterval(checkScrollPosition, interval);
}
function callback_endless(no) {
    if ( hasNoMoreContent() ) return;
//    showEndlessPageLoader();
    bEndLessInLoading = true;
    var post_id = $(".page").attr('post_id');
    $.ajax(url_server_app + 'postListMore/' + post_id + '?page_no=' + no + "&session_login=" + $session_id )
        .done(function(html){
            if ( html == '' ) {
                setNoMoreContent();
                hideEndlessPageLoader();
                endEndLessPage();
            }
            else {
                $(".page").append(html);
                hideEndlessPageLoader();
                showEndlessPageLoader();
            }
            bEndLessInLoading = false;
        })
        .fail(function(){
            alert('error on postListMore');
            bEndLessInLoading = false;
            hideEndlessPageLoader();
        });
}
function showEndlessPageLoader() {
    var src = url_server + '/module/app/img/loader5.gif';
    $('.page').append("<div class='loader-endless-page'><img src='"+src+"'></div>")
}
function hideEndlessPageLoader() {
    $('.loader-endless-page').remove();
}
function clearEndlessPage() {
    if ( $('.page').attr('post_id') ) iScrollCont = 1;
    else iScrollCont = 0;
    bNoMoreContent = false;
}
function setNoMoreContent() {
    bNoMoreContent = true;
    var text = getNoMoreContent();
    $(".page").append("<div class='no-more-content'>"+text+"</div>");
}
function hasNoMoreContent() {
    return bNoMoreContent;
}
