<?php
use sap\src\Request;

$url_site = sysconfig(URL_SITE);
echo "URL SITE: $url_site\n";



check_same(add_javascript('/core/module/user/js/abc.js'), $url_site . '/core/module/user/js/abc.js');
check_same(add_javascript('abc.js', "c:/work/www/sapcms2/core/module/user/template/def.html.php"), $url_site . 'core/module/user/js/abc.js' );
check_same(add_javascript('abc.js', "c:/work/www/sapcms2/module/user/template/def.html.php"), $url_site . 'module/user/js/abc.js' );
check_same(add_javascript('abc.js', "c:/work/www/sapcms2/theme/user/template/def.html.php"),$url_site . 'theme/user/js/abc.js' );
check_same(add_javascript('abc.js', "c:/work/www/sapcms2/widget/user/def.html.php"), $url_site . 'widget/user/js/abc.js' );
check_same(add_javascript(null, "c:/work/www/sapcms2/core/module/user/template/def.html.php"), $url_site . 'core/module/user/js/def.js' );
check_same(add_javascript(null, "c:/work/www/sapcms2/module/user/template/def.html.php"), $url_site . 'module/user/js/def.js' );
check_same(add_javascript(null, "c:/work/www/sapcms2/theme/user/template/def.html.php"), $url_site . 'theme/user/js/def.js' );
check_same(add_javascript(null, "c:/work/www/sapcms2/widget/user/def.php"),$url_site . 'widget/user/js/def.js' );



echo "Checking CSS...\n";
check_same( add_css('/core/module/user/css/abc.css'), $url_site . 'core/module/user/css/abc.css' );
check_same( add_css('abc.css', "c:/work/www/sapcms2/core/module/user/template/def.html.php"), $url_site . 'core/module/user/css/abc.css' );
check_same( add_css('abc.css', "c:/work/www/sapcms2/module/user/template/def.html.php"), $url_site . 'module/user/css/abc.css' );
check_same( add_css('abc.css', "c:/work/www/sapcms2/theme/user/template/def.html.php"), $url_site . 'theme/user/css/abc.css' );
check_same( add_css('abc.css', "c:/work/www/sapcms2/widget/user/def.html.php"), $url_site . 'widget/user/css/abc.css' );
check_same( add_css(null, "c:/work/www/sapcms2/core/module/user/template/def.html.php"), $url_site . 'core/module/user/css/def.css' );
check_same( add_css(null, "c:/work/www/sapcms2/module/user/template/def.html.php"), $url_site . 'module/user/css/def.css' );
check_same( add_css(null, "c:/work/www/sapcms2/theme/user/template/def.html.php"), $url_site . 'theme/user/css/def.css' );
check_same( add_css(null, "c:/work/www/sapcms2/widget/user/def.php"), $url_site . 'widget/user/css/def.css' );



function check_same($path, $comp) {
    if ( $path == $comp ) echo "OK\n";
    else echo "ERROR: $path != $comp\n";
}
