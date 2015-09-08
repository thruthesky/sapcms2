<?php
	//echo strtotime( "2015/08/02" );exit;

	extract( $variables );	
		
	//just for page title
	$list =	[
			'comment'=>'Most Comments',
			'post'=>'Most User Posts ( comments not counted )',
			//'idx_config'=>'Most Config Posts ( comments not counted )',
			];
?>

<?php include template("statistics.admin.$data[menu].menu"); ?>
<?php include template("statistics.admin.form"); ?>

<?php
	
?>

<div class='graph-wrapper'>
			<div class='inner'>
<?php
if( empty( $data['error'] ) ){
	for( $i2 = 0; $i2<=$data['max_total'];$i2+=$data['graph_interation'] ){ ?>
		<div class='num-label' style='bottom:<?php echo ( $i2/$data['max_total'] * 100 ) ?>%'>
			<div><?php echo $i2 ?></div>
		</div>
	<?php } 
	
		$color_range = [];
		$color_i = 0;
		for( $ci = 0; $ci <= 2; $ci++ ){
			$color_range[] = range(0,255);
			shuffle( $color_range[$ci] );
		}
		
		foreach( $data['overall_statistics'] as $collection ){						
			if( !empty( $collection['count'] ) ){
				$title = $collection['title'];
				$idx = $collection['idx'];
				$count = $collection['count'];
				
				$color_code = " style='background-color:rgba(".$color_range[0][$color_i].",".$color_range[1][$color_i].",".$color_range[2][$color_i].",1)'";
			}
			else{
				$title = $collection['title'];
				$idx = "";
				$count = 0;
				$color_code = null;
			}
			/*if( !empty( $collection['title'] ) ) $title = $collection['title'];
			if( !empty( $collection['idx'] ) ) $idx = $collection['idx'];
			if( !empty( $collection['count'] ) ) $count = $collection['count'];*/
			
			?>
				<div class='bar-wrapper<?php if( $count > 0 ) echo ' has-value'?>' style='width:<?php echo $data['custom_bar_width']; ?>%'>
					<div class='bar' title='<?php echo strip_tags( str_replace( "<br>", " - ", $title ) ); ?>' style='height:<?php echo ( $count/$data['max_total'] ) * 100; ?>%'>
						<div class='inner'<?php echo $color_code; ?>></div>
					</div>
					<div class='custom_title'>
						<span class='close'>[x]</span>
						<div class='triangle outer'></div>
						<div class='triangle inner'></div>																				
						<?php echo $title; ?>										
					</div>
				</div>
			<?php
			$color_i++;
		}
	?>
<?php
}
?>
	</div><!--/graph-wrapper /inner-->
</div><!--/graph-wrapper-->