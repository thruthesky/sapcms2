$(function(){
    $("body").on("change", "[name='province']", function(){
        var $this = $(this);
        var url = '/?widget=philippines_province_city&province=' + $this.val();
        console.log(url);
        $.ajax(url)
            .done(function(data){
                var $city = $(".row.city");
                if ( $city.length ) {
                    $city.remove();
                }
                $(data).insertAfter($this.parents('.row'));
            })
            .fail(function(data){
                alert(data);
            });
    });
});

