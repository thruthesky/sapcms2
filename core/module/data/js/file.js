var isUploadSubmit = false;
var file_upload_form_name = null; // last upload file box
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

    $('body').on("click",".file-display .delete", function(){
        var idx = $(this).parent().attr('idx');
        //console.log("why man call ? " + idx);
        fileDelete(idx);
    });
    $(".ajax-file-upload").submit(function(){
        if ( isUploadSubmit == false ) return true;
        var $this = $(this);
        console.log("form: "+ $this.find("[name='idx_parent']").val());
        var $progressBar = $this.find(".ajax-file-upload-progress-bar");
        var lastAction = $this.prop('action');
        $this.prop('action', '/file/upload');

        $this.ajaxSubmit({
            beforeSend: function() {
                console.log("bseforeSend:");
                showProgressBar();
            },
            uploadProgress: function(event, position, total, percentComplete) {
                console.log("while uploadProgress:" + percentComplete + '%');
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