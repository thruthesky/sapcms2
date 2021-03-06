<?php
	$date_label = 	[
				'day'=>'daily',	
				'week'=>'Weekly',	
				'month'=>'Monthly',
				];

	if( $data['show_by'] == 'day' ) $input_date_type = 'date';
	else $input_date_type = $data['show_by'];
	if( !empty( $data['group_by'] ) ){
		if( $data['group_by'] == 'idx_user' ) $group_by_label = 'User';
		else if( $data['group_by'] == 'idx_config' ) $group_by_label = 'Forum';
		else $group_by_label = $data['group_by'];
	}
?>
<form>
	<input type='hidden' name='list_type' value='<?php echo $data['list_type'] ?>'>
	<?php if( !empty( $data['group_by'] ) ) {
		if( empty( $data['group_by_value'] ) ) $data['group_by_value'] = null;
	?>
		<input type='hidden' name='group_by' value='<?php echo $data['group_by'] ?>'>
		Input <?php echo $group_by_label ?> IDX or <?php echo $group_by_label ?> ID <span class='note important'>*Required</span>
		<?php if( $data['group_by'] == 'idx_config'){
			$post_configs = entity( POST_CONFIG )->rows();		
			
		?>
			<select name='group_by_value'>
				<option value=""></option>
				<?php foreach( $post_configs as $pc ){?>
					<option value='<?php echo $pc['idx']?>' <?php if( $data['group_by_value'] == $pc['idx'] ) echo " selected" ?>><?php echo $pc['id']?></option>
				<?php }?>
			</select>
		<?php }else{?>
			<input type='text' name='group_by_value' value='<?php echo $data['group_by_value'] ?>'>
		<?php }?>
	<?php } ?>
	From
	<input type='<?php echo $input_date_type; ?>' name='date_from' value='<?php echo $data['date_from']?>'>
	To
	<input type='<?php echo $input_date_type; ?>' name='date_to' value='<?php echo $data['date_to']?>'>
	
	Show by:
	<select name='show_by'>
		<!--<option value="">ALL</option>-->
		<?php foreach( $date_label as $key => $value ){ ?>
			<option value='<?php echo $key?>' <?php if( $key == $data['show_by'] ) echo " selected" ?>><?php echo $value?></option>
		<?php } ?>
	</select>
	
	<input type='submit' value='submit'>
</form>