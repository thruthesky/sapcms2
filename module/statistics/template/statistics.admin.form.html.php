<?php
	//just text for date_by
	$text =	[
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
	<?php if( !empty( $data['group_by'] ) ) {?>
		<input type='hidden' name='group_by' value='<?php echo $data['group_by'] ?>'>
		Input <?php echo $group_by_label ?> IDX or <?php echo $group_by_label ?> ID
		<input type='text' name='group_by_value' value='<?php echo $data['group_by_value'] ?>'>
	<?php } ?>
	From
	<input type='<?php echo $input_date_type; ?>' name='date_from' value='<?php echo $data['date_from']?>'>
	To
	<input type='<?php echo $input_date_type; ?>' name='date_to' value='<?php echo $data['date_to']?>'>
	
	Show by:
	<select name='show_by'>
		<!--<option value="">ALL</option>-->
		<?php foreach( $text as $key => $value ){ ?>
			<option value='<?php echo $key?>' <?php if( $key == $data['show_by'] ) echo " selected" ?>><?php echo $value?></option>
		<?php } ?>
	</select>
	
	<input type='submit' value='submit'>
</form>