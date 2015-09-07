<?php
//will use later......
if( empty( $data['group_by'] ) ) $group_by = $data['list_type'];
else $group_by = $data['group_by'];


//getting max_total, graph interation
$start_stamp = $data['date_from_stamp'][$data['show_by']];
$end_stamp = $data['date_to_stamp'][$data['show_by']];			

$q = "created > $start_stamp AND created < $end_stamp";	
if( !empty( $data['extra_query'] ) ) $q .= " $data[extra_query]";
$q .= $data['sql_group_by']."$group_by";

$count_per_day = entity(POST_DATA)->rows( $q, "created$group_by,count(*)" );	

//0=day,1=idx_parent,2=count
$items = [];			
$highest = 0;	
if( !empty( $count_per_day ) ){
	foreach( $count_per_day as $arr ){
		$arr = array_values( $arr );
		
		if( $data['date_guide'] == 'week' ) $date_index = "W".date( "W-Y", strtotime( "this week", $arr[0] ) );													
		else $date_index = date( "$data[date_guide]",( $arr[0] ) );
		
		$items[ $date_index ][$arr[1]] = $arr[2];					
		if( $highest < $arr[2] ) $highest = $arr[2];
	}
}

$max_total_iteration = 1;
$temp_i = $highest;
while( $temp_i > 10 ){
	$max_total_iteration *= 10;
	$temp_i = $temp_i/10;										
}

$custom_bar_width = 100 / ( $data['difference'][$data['show_by']] + 1 );

$max_total = ceil( $highest/$max_total_iteration ) * $max_total_iteration;
if( empty( $max_total ) || $max_total < 10 ) $max_total = 10;

$graph_interation = ceil( $max_total / 20 );
//for bar guide
for( $i2 = 0; $i2<=$max_total;$i2+=$graph_interation ){ ?>
	<div class='num-label' style='bottom:<?php echo ( $i2/$max_total * 100 ) ?>%'>
		<div><?php echo $i2 ?></div>
	</div>
<?php } ?>
