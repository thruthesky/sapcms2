<?php

use sap\core\theme\ThemeConfig;

function theme_config($domain=null) {
    if ( $domain ) {
        if ( is_numeric($domain) ) return theme_config()->load($domain);
        return theme_config()->load('code', $domain);
    }
    return new ThemeConfig();
}
