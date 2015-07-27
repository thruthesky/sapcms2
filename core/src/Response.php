<?php
class Response {
    /**
     * @param $url
     *
     * Attention It ends the script.
     */
    public static function redirect($url) {
        echo Javascript::location($url);
    }

    public static function html($content)
    {
        $html = HTML::create();
        $html->meta('charset', 'utf8');
        $html->body($content);
        echo $html->get();
    }

    public static function renderLayout($filename=null) {
        ob_start();
        include theme_layout();
        $content = ob_get_clean();
        echo $content;
    }

}