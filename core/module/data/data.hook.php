<?php
function hook_user_getCurrent_data() {
    $s = segment(1);
    if ( $s == 'thumbnail' ) {
        return FALSE;
    }
}
function hook_theme_getTheme_data() {
    $s = segment(1);
    if ( $s == 'thumbnail' ) {
        return '';
    }
    return null;
}