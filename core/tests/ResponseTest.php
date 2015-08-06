<?php

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public function test_css()
    {
        $url_site = system_config(URL_SITE);
        $this->assertTrue( add_css('/core/module/user/css/abc.css') == '/core/module/user/css/abc.css' );
        $this->assertTrue( add_css('abc.css', "c:/work/www/sapcms2/core/module/user/template/def.html.php") == $url_site . 'core/module/user/css/abc.css' );
        $this->assertTrue( add_css('abc.css', "c:/work/www/sapcms2/module/user/template/def.html.php") == $url_site . 'module/user/css/abc.css' );
        $this->assertTrue( add_css('abc.css', "c:/work/www/sapcms2/theme/user/template/def.html.php") == $url_site . 'theme/user/css/abc.css' );
        $this->assertTrue( add_css('abc.css', "c:/work/www/sapcms2/widget/user/def.html.php") == $url_site . 'widget/user/css/abc.css' );
        $this->assertTrue( add_css(null, "c:/work/www/sapcms2/core/module/user/template/def.html.php") == $url_site . 'core/module/user/css/def.css' );
        $this->assertTrue( add_css(null, "c:/work/www/sapcms2/module/user/template/def.html.php") == $url_site . 'module/user/css/def.css' );
        $this->assertTrue( add_css(null, "c:/work/www/sapcms2/theme/user/template/def.html.php") == $url_site . 'theme/user/css/def.css' );
        $this->assertTrue( add_css(null, "c:/work/www/sapcms2/widget/user/def.php") == $url_site . 'widget/user/css/def.css' );
    }

    public function test_javascript()
    {
        $url_site = system_config(URL_SITE);
        $this->assertTrue( add_javascript('/core/module/user/js/abc.js') == '/core/module/user/js/abc.js' );
        $this->assertTrue( add_javascript('abc.js', "c:/work/www/sapcms2/core/module/user/template/def.html.php") == $url_site . 'core/module/user/js/abc.js' );
        $this->assertTrue( add_javascript('abc.js', "c:/work/www/sapcms2/module/user/template/def.html.php") == $url_site . 'module/user/js/abc.js' );
        $this->assertTrue( add_javascript('abc.js', "c:/work/www/sapcms2/theme/user/template/def.html.php") == $url_site . 'theme/user/js/abc.js' );
        $this->assertTrue( add_javascript('abc.js', "c:/work/www/sapcms2/widget/user/def.html.php") == $url_site . 'widget/user/js/abc.js' );
        $this->assertTrue( add_javascript(null, "c:/work/www/sapcms2/core/module/user/template/def.html.php") == $url_site . 'core/module/user/js/def.js' );
        $this->assertTrue( add_javascript(null, "c:/work/www/sapcms2/module/user/template/def.html.php") == $url_site . 'module/user/js/def.js' );
        $this->assertTrue( add_javascript(null, "c:/work/www/sapcms2/theme/user/template/def.html.php") == $url_site . 'theme/user/js/def.js' );
        $this->assertTrue( add_javascript(null, "c:/work/www/sapcms2/widget/user/def.php") == $url_site . 'widget/user/js/def.js' );
    }
}

