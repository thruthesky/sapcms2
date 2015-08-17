

<?php include template('bulk.menu'); ?>

<?php
echo "<h4>CONDITION: $variables[cond]</h4>";
?>

<?php
if ( $variables['numbers'] ) {
    echo "<h2>No. of SMS to send : " . count($variables['numbers']) . '</h2>';
}
else {
if ( empty($variables['numbers']) ) {
    echo "<h2>No. of SMS to send : " . count($variables['numbers']) . '</h2>';
    echo "
                <div>
                There is no number by that search.<br>
                                1. Maybe all number in the search has sent within the 'days'<br>
                                2. Maybe there is no number in that province or category.<br>
                </div>
            ";
}
}
?>


<?php
if ( isset($variables['in_queue']) && $variables['in_queue'] ) {
    echo "<H1>ALREADY IN QUEUE with same bulk</H1>";
    foreach( $variables['in_queue'] as $number ) {
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