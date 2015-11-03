<?php
$error = getError();
if ( empty($error) ) return;
add_css();
?>
<section class="error">
    <h2>Error</h2>
    <div class="list">
        <?php

        foreach ( $error as $code => $message ) {
            if ( is_array($message) ) {
                $message = print_r($message, true);
            }
            echo "
            <div class='row'>
            <div class='code'>
                $code
            </div>
            <div class='message'>
                $message
            </div>
            </div>
            ";
        }
        ?>
    </div>
</section>