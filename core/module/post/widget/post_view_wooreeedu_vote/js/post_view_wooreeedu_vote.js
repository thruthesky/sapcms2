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
					$(".vote ." + re.type + " img").attr("src","/core/module/post/widget/post_view_wooreeedu_vote/img/like_active.png");					
					if( re.no > 1 ){						
						var html = $(".vote ." + re.type).html();
						if( html.indexOf( "Likes" ) != -1 ){
						
						}
						else{
							html = html.replace("Like","Likes");
							$(".vote ." + re.type).html( html );
						}
					}
                }
            })
            .fail(function(data){
                console.log(re);
            });
    });
});
