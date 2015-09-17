$(function(){
    var countEnter = [];
    var doneShowOnClick = [];
    $("form[name='comment']").click(function(){
        var $this = $(this);
        var no = $this.attr('no');
        console.log('no:' + no);
        if ( doneShowOnClick[no] == true ) return;
        else doneShowOnClick[no] = true;

        console.log('done:' + doneShowOnClick[no]);

        $this.find(".show-on-click").show();
        $this.find('textarea').css('height', '60');
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