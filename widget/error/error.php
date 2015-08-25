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