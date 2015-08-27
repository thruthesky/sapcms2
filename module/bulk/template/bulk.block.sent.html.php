<H1>BLOCKED!!</H1>

<?php
	if( !empty( $variables['scheduled'] ) ){
		foreach( $variables['scheduled'] as $schedule ){
		
			echo "<div>$schedule[message] $schedule[number]</div>";
		
		}
	}
?>

<H1>ERROR</H1>

<?php
	if( !empty( $variables['error_number'] ) ){
		foreach( $variables['error_number'] as $error ){
		
		echo "<div>$error[message] $error[number]</div>";
		
		}
	}
?>