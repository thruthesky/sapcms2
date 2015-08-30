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
$(function(){
    $(".ajax-file-upload").submit(function(){
        if ( isUploadSubmit == false ) return true;
        var $this = $(this);
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
                //console.log(re);

                fileDisplay(re);
                fileCallback(re);
                setFid(re);

            }
        });
        function fileDisplay(re) {
            var display = $this.find('[name="file_display"]').val();
            if ( display ) {
                var name = file_upload_form_name.replace('[]', '');
                var $display = $(".file-display." + name);
                if ( $display.length == 0 ) {
                    $this.find("[name='"+file_upload_form_name+"']").after("<div class='file-display "+name+"'></div>");
                    $display = $(".file-display." + name);
                }
                for ( var i in re ) {
                    var file = re[i];
                    var img = "<img src='"+file.url+"'>";
                    $display.append(img);
                }
            }
        }
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