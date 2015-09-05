$(function(){
    $("body").on("click", ".vote > div", function() {
        var $this = $(this);
        var $vote = $this.parent();
        var url = "/post/vote/" + $this.prop('class') + "/" + $vote.attr('idx');
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
            .fail(function(data){
                console.log(re);
            });
    });
});
