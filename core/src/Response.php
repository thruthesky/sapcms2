<?php
namespace sap\src;
use sap\core\System\System;

class Response {
    /**
     * @param $url
     *
     * Attention It ends the script.
     */
    public static function redirect($url) {

        self::setHeaders();
        echo Javascript::location($url);
    }

    public static function html($content)
    {
        $html = HTML::create();
        $html->meta('charset', 'utf8');
        $html->body($content);

        self::setHeaders();
        echo $html->get();
    }

    public static function renderLayout($render=[]) {

        System::setRender($render);

        ob_start();

        $path = theme_layout();
        if ( file_exists($path) ) include $path;
        else include system_layout();

        $content = ob_get_clean();

        self::setHeaders();
        echo $content;

    }


    public static function renderSystemLayout($render=[]) {
        System::setRender($render);
        ob_start();
        include system_layout();
        $content = ob_get_clean();
        self::setHeaders();
        echo $content;
    }


    private static function setHeaders()
    {
        if ( System::isCommandLineInterface() ) {

        }
        else {
            header('Content-Type: text/html; charset=UTF-8');
        }
    }

}
