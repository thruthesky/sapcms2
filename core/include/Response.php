<?php
class Response {
    /**
     * @param $url
     *
     * Attention It ends the script.
     */
    public static function redirect($url) {
        echo Javascript::location($url);
        exit;
    }

    public static function html($content)
    {
        $html = HTML::create();
        $html->meta('charset', 'utf8');
        $html->body($content);
        echo $html->get();
        exit;
    }
}