<?php
use sap\src\Request;

$url_site = system_config(URL_SITE);
echo "URL SITE: $url_site\n";


$path = add_javascript('/core/module/user/js/abc.js');
if ( $path == '/core/module/user/js/abc.js' ) echo "OK\n";
else echo "ERROR: $path\n";

$path = add_javascript('abc.js', "c:/work/www/sapcms2/core/module/user/template/def.html.php");
if ( $path == $url_site . 'core/module/user/js/abc.js' ) echo "OK\n";
else echo "ERROR: $path\n";

$path = add_javascript('abc.js', "c:/work/www/sapcms2/module/user/template/def.html.php");
if ( $path == $url_site . 'module/user/js/abc.js' ) echo "OK\n";
else echo "ERROR: $path\n";

$path = add_javascript('abc.js', "c:/work/www/sapcms2/theme/user/template/def.html.php");
if ( $path == $url_site . 'theme/user/js/abc.js' ) echo "OK\n";
else echo "ERROR: $path\n";

$path = add_javascript('abc.js', "c:/work/www/sapcms2/widget/user/def.html.php");

if ( $path == $url_site . 'widget/user/js/abc.js' ) echo "OK\n";
else echo "ERROR: $path\n";

$path = add_javascript(null, "c:/work/www/sapcms2/core/module/user/template/def.html.php");
if ( $path == $url_site . 'core/module/user/js/def.js' ) echo "OK\n";
else echo "ERROR: $path\n";

$path = add_javascript(null, "c:/work/www/sapcms2/module/user/template/def.html.php");
if ( $path == $url_site . 'module/user/js/def.js' ) echo "OK\n";
else echo "ERROR: $path\n";

$path = add_javascript(null, "c:/work/www/sapcms2/theme/user/template/def.html.php");
if ( $path == $url_site . 'theme/user/js/def.js' ) echo "OK\n";
else echo "ERROR: $path\n";

$path = add_javascript(null, "c:/work/www/sapcms2/widget/user/def.html.php");
if ( $path == $url_site . 'widget/user/js/def.js' ) echo "OK\n";
else echo "ERROR: $path\n";



function check_css($path, $comp) {
    if ( $path == $comp ) echo "OK\n";
    else echo "ERROR: $path\n";
}

echo "Checking CSS...\n";
check_css( add_css('/core/module/user/css/abc.css'), '/core/module/user/css/abc.css' );
check_css( add_css('abc.css', "c:/work/www/sapcms2/core/module/user/template/def.html.php"), $url_site . 'core/module/user/css/abc.css' );
check_css( add_css('abc.css', "c:/work/www/sapcms2/module/user/template/def.html.php"), $url_site . 'module/user/css/abc.css' );
check_css( add_css('abc.css', "c:/work/www/sapcms2/theme/user/template/def.html.php"), $url_site . 'theme/user/css/abc.css' );
check_css( add_css('abc.css', "c:/work/www/sapcms2/widget/user/def.html.php"), $url_site . 'widget/user/css/abc.css' );
check_css( add_css(null, "c:/work/www/sapcms2/core/module/user/template/def.html.php"), $url_site . 'core/module/user/css/def.css' );
check_css( add_css(null, "c:/work/www/sapcms2/module/user/template/def.html.php"), $url_site . 'module/user/css/def.css' );
check_css( add_css(null, "c:/work/www/sapcms2/theme/user/template/def.html.php"), $url_site . 'theme/user/css/def.css' );
check_css( add_css(null, "c:/work/www/sapcms2/widget/user/def.html.php"), $url_site . 'widget/user/css/def.css' );
