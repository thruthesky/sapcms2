<?php

?>

<?php include template('bulk.menu'); ?>

<?php
if ( $variables['numbers'] ) {
    echo "Number of SMS TEXT : " . count($variables['numbers']);
}
?>


<?php
if ( isset($variables['in_queue']) && $variables['in_queue'] ) {
    echo "<H1>ALREADY IN QUEUE with same bulk</H1>";
    foreach( $variables['in_queue'] as $number ){
        echo "<div>$number</div>";
    }
}
?>


<?php
if ( isset($variables['already_sent']) && $variables['already_sent']) {
    echo "<H1>ALREADY IN SENT with same bulk</H1>";
    foreach( $variables['already_sent'] as $number ){

        echo "<div>$number</div>";
    }
}
?>

<H1>SCHEDULED FOR SMS SENDING!!</H1>
<?php
if ( isset($variables['scheduled']) ) {
    if ( $variables['scheduled'] ) {
        foreach( $variables['scheduled'] as $schedule ){
            echo "<div>$schedule[number]</div>";
        }
    }
    else {
        echo "<div>No number is scheduled</div>";
    }
}
?>

<H1>ERROR</H1>
<?php
if ( isset($variables['error_number']) ) {
    if ( $variables['error_number'] ) {
        foreach( $variables['error_number'] as $error ){
            echo "<div>$error[number] - $error[message]</div>";
        }
    }
    else {
        echo "<div>No error</div>";
    }
}
?>