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
}