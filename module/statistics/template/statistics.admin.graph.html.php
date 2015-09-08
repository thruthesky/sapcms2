<?php
	//echo strtotime( "2015/08/02" );exit;

	extract( $variables );	
		
	//just for page title
	$list_type =	[
					'comment'=>'Most Comments',
					'post'=>'Most User Posts ( comments not counted )',
					'created'=>'User Registers',
					'updates'=>'User Updates',
					'logins'=>'User Logins',
					'block'=>'How many users will still be BLOCKED on the said date',
					'resign'=>'Resigned Users',
					];
?>

<?php include template("statistics.admin.$data[menu].menu"); ?>

<h1>
	<?php 
		echo $list_type[ $data['list_type'] ]; 
		if( !empty( $data['group_by'] ) ) echo " Grouped by ".$data['group_by'];
	?>
</h1>

<?php include template("statistics.admin.form"); ?>

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
				
				
				$inner_inline_style = " style='background-color:rgba(".$color_range[0][$color_i].",".$color_range[1][$color_i].",".$color_range[2][$color_i].",1)";
				if( !empty( $collection['border_code'] ) ) {
						$border_color = 255 - $collection['border_code'];
						$inner_inline_style .= ";border-bottom:5px solid;border-color:rgba(".$color_range[0][$border_color].",".$color_range[1][$border_color].",".$color_range[2][$border_color].",1)";
					}
				$inner_inline_style .= ";'";

			}
			else{
				$title = $collection['title'];
				$idx = "";
				$count = 0;
				$inner_inline_style = null;
			}
			
			?>
				<div class='bar-wrapper<?php if( $count > 0 ) echo ' has-value'?>' style='width:<?php echo $data['custom_bar_width']; ?>%'>
					<div class='bar' title='<?php echo strip_tags( str_replace( "<br>", " - ", $title ) ); ?>' style='height:<?php echo ( $count/$data['max_total'] ) * 100; ?>%'>
						<div class='inner'<?php echo $inner_inline_style; ?>></div>
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