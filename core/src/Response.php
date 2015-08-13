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
     * @return int
     */
    public static function redirect($url) {
        self::setHeaders();
        echo Javascript::location($url);
        return OK;
    }


    /**
     * @param array $variables
     * @return mixed|null - self::processContent() for the return value
     *
     *
     */
    public static function renderTemplate($variables=[])
    {
        System::setRender($variables);
        ob_start();
        include template();
        $content = ob_get_clean();
        self::setHeaders();
        return self::processContent($content);
    }

    /***
     * @param $content
     * @return mixed|null - self::processContent() for the return value
     */
    public static function html($content)
    {
        $html = HTML::create();
        $html->meta('charset', 'utf8');
        $html->body($content);
        self::setHeaders();
        $content = $html->get();
        return self::processContent($content);
    }

    /**
     * @param array $variables
     * @return mixed|null - self::processContent() for the return value
     */
    public static function renderLayout($variables=[]) {

        System::setRender($variables);

        ob_start();

        $path = theme_layout();
        if ( file_exists($path) ) include $path;
        else include system_layout();

        $content = ob_get_clean();

        self::setHeaders();
        return self::processContent($content);
    }


    /**
     * @param array $variables
     * @return mixed|null - self::processContent() for the return value
     */
    public static function renderSystemLayout($variables=[]) {
        if ( System::isCommandLineInterface() ) return OK;
        System::setRender($variables);

        ob_start();
        include system_layout();
        $content = ob_get_clean();

        self::setHeaders();

        return self::processContent($content);
    }


    private static function setHeaders()
    {
        if ( System::isCommandLineInterface() ) {

        }
        else {
            header('Content-Type: text/html; charset=UTF-8');
        }
    }

    public static function addJavascript($filename, $base=null)
    {
        if ( empty($filename) ) {
            $path = get_sapcms_path($base);
            if ( strpos($path,'/template/') ) {
                $path = str_replace(".html.php", '.js', $path);
                $path = str_replace("/template/", '/js/', $path);
            }
            else {
                $path = str_replace(".php", '.js', $path);
                $pu = pathinfo($path);
                $path = str_replace($pu['basename'], "js/$pu[basename]", $path);
            }
        }

        else if ( strpos($filename, '//') === 0 ) {
            $path = $filename;
        }
        else if ( strpos($filename, 'http') === 0 ) {
            $path = $filename;
        }

        else if ( strpos($filename, '/') === FALSE ) {
            $path = get_sapcms_path($base);
            $pu = pathinfo($path);
            $path = str_replace($pu['basename'], $filename, $path);
            if ( strpos($path,'/template/') ) {
                $path = str_replace("/template/", '/js/', $path);
            }
            else {
                $path = str_replace($filename, "js/$filename", $path);
            }
        }
        else {
            $path = $filename;
        }
        $path = url_complete($path);
        self::$javascript[$path] = true;
        return $path;
    }

    public static function addCss($filename, $base=null)
    {
        if ( empty($filename) ) {
            $path = get_sapcms_path($base);
            if ( strpos($path,'/template/') ) {
                $path = str_replace(".html.php", '.css', $path);
                $path = str_replace("/template/", '/css/', $path);
            }
            else {
                $path = str_replace(".php", '.css', $path);
                $pu = pathinfo($path);
                $path = str_replace($pu['basename'], "css/$pu[basename]", $path);
            }
        }
        else if ( strpos($filename, '//') === 0 ) {
            $path = $filename;
        }
        else if ( strpos($filename, 'http') === 0 ) {
            $path = $filename;
        }
        else if ( strpos($filename, '/') === FALSE ) {
            $path = get_sapcms_path($base);
            $pu = pathinfo($path);
            $path = str_replace($pu['basename'], $filename, $path);
            if ( strpos($path,'/template/') ) {
                $path = str_replace("/template/", '/css/', $path);
            }
            else {
                $path = str_replace($filename, "css/$filename", $path);
            }
        }
        else {
            $path = $filename;
        }
        $path = url_complete($path);
        self::$css[$path] = true;
        return $path;
    }

    /**
     *
     * @ATTENTION This is the actual method that prints out HTML data to web browser.
     *
     *  - If this is a CLI run, then it only RETURNS the HTML content without printing out.
     *
     * @param $content
     * @return mixed|null
     */
    private static function processContent(&$content)
    {
        $content = str_ireplace('</head>', self::getCss() . '</head>', $content);
        $content = str_ireplace('</body>', self::getJavascript() . '</body>', $content);
        if ( System::isCommandLineInterface() ) return $content;
        else {
            echo $content;
            return null;
        }
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

    public static function render($data=[])
    {
        return self::renderLayout($data);
    }

    public static function json($data) {
        header("Access-Control-Allow-Origin: *");
        echo json_encode($data);
        return OK;
    }


}
