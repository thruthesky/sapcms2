$(function(){
	$("body").on( "click",".message-list-body .row", show_message );
});

function show_message(){	
	$this = $(this);			
	$this.find('.show-on-click').slideDown();
	
	if( $this.hasClass('sent') ) return;
	
	if( $this.hasClass('unread') ){
		$this.removeClass('unread');		
		
		idx = $this.attr('idx');
		url = '/message/markAsRead?idx='+idx;
		$.ajax({
			'url': url,
			'data' : { 'idx': idx }
		})
			.done(function(data) {			
				var re = JSON.parse(data);	
				if( re.error == 0 ){
				
				}
				else{
					alert( re.message );
				}
			})
			.fail(function() {
				
			});
	}
}