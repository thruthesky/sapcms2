<?php

?>

<H1>SENT!!</H1>

<?php
	foreach( $variables['scheduled'] as $schedule ){
	
		echo "<div>$schedule[message] --> $schedule[number]</div>";
	
	}
?>

<H1>ERROR</H1>

<?php
	foreach( $variables['error_number'] as $error ){
	
	echo "<div>$error[number] - $error[message]</div>";
	
	}
?>