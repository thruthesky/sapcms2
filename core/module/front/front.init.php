<?php
register_hook('theme_script', function(&$filename){
    if ( $filename == 'front.front.defaultController' ) $filename = "front";
});