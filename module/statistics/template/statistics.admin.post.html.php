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

<?php include template('statistics.admin.post.menu'); ?>
<?php include template('statistics.admin.form'); ?>

<?php
if( empty( $data['error'] ) ){
?>
	<h1>User Statistics</h1>
	<?php
	?>
		<h2>
			<?php
				//just for title...
				echo $list[$data['list_type']];
			?>
		</h2>
		<div class='graph-wrapper'>
			<div class='inner'>
				<?php			
				//getting max_total, graph interation
				$start_stamp = $data['date_from_stamp'][$data['show_by']];
				$end_stamp = $data['date_to_stamp'][$data['show_by']];
				
				$q = "created > $start_stamp AND created < $end_stamp";	
				if( !empty( $data['extra_query'] ) ) $q .= " $data[extra_query]";
				$q .= $data['sql_group_by'];		
								
				$count_per_day = entity(POST_DATA)->rows( $q, "created,count(*)" );
								
				//di( date( "r", 1441263980 ) );
				//di( $count_per_day );exit;	
				$items = [];				
				$highest = 0;		
				
				//0=day,1=count
				if( !empty( $count_per_day ) ){	
					foreach( $count_per_day as $arr ){
						$arr = array_values( $arr );
						//temp
						if( $data['date_guide'] == 'week' ) $date_index = "W".date( "W-Y", strtotime( "this week", $arr[0] ) );													
						else $date_index = date( "$data[date_guide]",( $arr[0] ) );
						
						$items[ $date_index ] = $arr[1];
						if( $highest < $arr[1] ) $highest = $arr[1];
					}
				}								
				
				$max_total_iteration = 1;
				$temp_i = $highest;
				while( $temp_i > 10 ){
					$max_total_iteration *= 10;
					$temp_i = $temp_i/10;										
				}
				
				$max_total = ceil( $highest/$max_total_iteration ) * $max_total_iteration;
				if( empty( $max_total ) ) $max_total = 10;
				
				$graph_interation = ceil( $max_total / 20 );
				//for bar guide
				for( $i2 = 0; $i2<=$max_total;$i2+=$graph_interation ){ ?>
					<div class='num-label' style='bottom:<?php echo ( $i2/$max_total * 100 ) ?>%'>
						<div><?php echo $i2 ?></div>
					</div>
				<?php } ?>
			
				<?php
		
				$date_now = $start_stamp;
				for( $i = 0; $i <= $data['difference'][$data['show_by']]; $i++ ){
					//echo date( "M d",$date_now )."<br>";
					if( $data['date_guide'] == 'week' ) $date_index = "W".date( "W-Y", strtotime( "this week", $date_now ) );													
					else $date_index = date( "$data[date_guide]",( $date_now ) );
					
					if( !empty( $items[ $date_index ] ) ) $count = $items[ $date_index ];
					else $count = 0;
					
					$url = "?list_type=$data[list_type]&date_from=".date( "Y-m-d",$date_now )."&date_to=".date( "Y-m-d",$date_now )."&show_by=".$data['show_by'];
						?>
							<div class='bar-wrapper<?php if( $count > 0 ) echo " has-value"; ?>'>
								<div class='bar' title='<?php echo $count; ?>' style='height:<?php echo ( $count/$max_total ) * 100; ?>%'>&nbsp;</div>
								<div class='date'>	
									<?php echo date( "M d",$date_now );?><br>
									<a href='<?php echo $url."&group_by=idx_user"; ?>' target='_blank'>U</a>
									<a href='<?php echo $url."&group_by=idx_config"; ?>' target='_blank'>C</a>
								</div>
							</div>
						<?php
									
				?>			
				
				<?php 
					$date_now = strtotime( date( "Y-m-d",$date_now )." +1 $data[show_by]" );	
				}
									
				?>
				<div style='clear:both'></div>
			</div><!--/inner-->
		</div><!--/graph-wrapper-->
<?php
}
?>

<style>
.graph-wrapper{	
	position:relative;
	height:500px;
	padding:10px 0 42px 0;
	overflow:hidden;
}

.graph-wrapper .inner{
	position:relative;
	height:500px;
	margin-left:20px;
}

.graph-wrapper .inner .num-label{
	position:absolute;
	left:-20px;
	width:100%;
	border-bottom:1px solid #d5d5d5;
	font-size:.7em;
}

.graph-wrapper .inner .num-label > div{
	position:absolute;
	left:0;
	bottom:-5px;
	padding:0 5px;
	background-color:#f9f9f9;
}

.graph-wrapper .inner .bar-wrapper{	
	position:relative;
	display:inline-block;	
	float:left;
	width:2%;
	height:500px;
	font-size:.7em;
	text-align:center;
}

.graph-wrapper .inner .bar-wrapper.has-value .bar{	
	min-height:1px;
}

.graph-wrapper .inner .bar-wrapper.label{	
	width:25px;
}

.graph-wrapper .inner .bar-wrapper .bar{
	position:absolute;
	left:0;
	bottom:0;
	width: 85%;
    margin-right: 15%;
	background-color:blue;
	cursor:pointer;
}

.graph-wrapper .inner .bar-wrapper .date{
	position:absolute;
	left:0;
	bottom:-42px;
	width:80%;
	z-index:1;
}
</style>
