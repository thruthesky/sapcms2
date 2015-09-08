<?php
	//echo strtotime( "2015/08/02" );exit;

	extract( $variables );	
		
	//just for page title
	$list_type =	[
					'comment'=>'Most Comments',
					'post'=>'Most Posts ( comments not counted )',
					'created'=>'User Registers',
					'updates'=>'User Updates',
					'logins'=>'User Logins',
					'block'=>'How many users will still be BLOCKED on the said date',
					'resign'=>'Resigned Users',					
					];
					
	//just text for keys
	$text =	[
			'day'=>'daily',	
			'week'=>'Weekly',	
			'month'=>'Monthly',
			'idx_user'=>'User',
			'idx_forum'=>'Forum',
			];	
?>

<?php include template("statistics.admin.$data[menu].menu"); ?>

<h1>
	<?php 
		echo $list_type[ $data['list_type'] ]; 
		if( !empty( $data['group_by'] ) ) echo " Grouped by ".$text[ $data['group_by'] ];
		if( !empty( $data['extra_title_text'] ) ) echo $data['extra_title_text'];
	?>
</h1>

<?php include template("statistics.admin.form"); ?>

<?php 
if( empty( $data['error'] ) ){
	if( empty( $data['group_by'] ) ){
		include template("statistics.admin.graph"); 
	}
	else{				
		if( !empty( $data[ 'group_by_value' ] ) || !empty( $data['input']['show_all'] ) ) {
			include template("statistics.admin.graph"); 
		}
	}
}
else{
?>
<h1><?php echo $data['error']?></h1>
<?php }?>