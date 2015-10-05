<?php
add_css();
?>

<div class='message-pagination'>
<?php
if( $widget['page_start'] > 1 ){
	if( !empty( $widget['default_url'] ) ) $url = $widget['default_url']."&page=".( $widget['page_start'] - $widget['paging'] );
	else $url = "?page=".( $widget['page_start'] - $widget['paging'] );	

	echo "<a href='$url'>Prev $widget[paging]</a>";
}
for( $i = $widget['page_start']; $i <= $widget['page_end']; $i ++ ){

	if( !empty( $widget['default_url'] ) ) $url = $widget['default_url']."&page=$i";
	else $url = "?page=$i";	
	
	echo "<a href='$url'>$i</a>";
}
if( $widget['max_pages'] > $widget['page_end'] ){

	if( !empty( $widget['default_url'] ) ) $url = $widget['default_url']."&page=".( $widget['page_start'] + $widget['paging'] );
	else $url = "?page=".( $widget['page_start'] + $widget['paging'] );	
	
	echo "<a href='$url'>Next $widget[paging]</a>";
}
?>
</div>