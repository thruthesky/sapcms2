<?php
namespace sap\src;
use sap\core\System\System;

class Response {

    public static $javascript = [];
    public static $css = [];

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
        $content = $html->get();
        self::processContent($content);
    }

    public static function renderLayout($render=[]) {

        System::setRender($render);

        ob_start();

        $path = theme_layout();
        if ( file_exists($path) ) include $path;
        else include system_layout();

        $content = ob_get_clean();

        self::setHeaders();
        self::processContent($content);

    }


    public static function renderSystemLayout($render=[]) {
        System::setRender($render);
        ob_start();
        include system_layout();
        $content = ob_get_clean();
        self::setHeaders();
        self::processContent($content);
    }


    private static function setHeaders()
    {
        if ( System::isCommandLineInterface() ) {

        }
        else {
            header('Content-Type: text/html; charset=UTF-8');
        }
    }

    public static function addJavascript($path)
    {
        self::$javascript[$path] = true;
    }

    public static function addCss($path)
    {
        self::$css[$path] = true;
    }

    private static function processContent(&$content)
    {
        $content = str_ireplace('</head>', self::getCss() . '</head>', $content);
        $content = str_ireplace('</body>', self::getJavascript() . '</body>', $content);
        echo $content;
    }

    private static function getCss()
    {
        if ( empty(self::$css) ) return null;
        $css = null;

        foreach( self::$css as $path => $v ) {
            $css .= "<link type='text/css' href='$path' rel='stylesheet' />" . PHP_EOL;
        }
        return $css;
    }

    private static function getJavascript()
    {
        if ( empty(self::$javascript) ) return null;
        $js = null;
        foreach( self::$javascript as $path => $v ) {
            $js .= "<script type='text/javascript' src='$path'></script>" . PHP_EOL;
        }
        return $js;
    }


}
