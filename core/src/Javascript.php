<?php
namespace sap\core;
class Javascript {
    public static function location($url) {
        return "<script>location.href='$url';</script>";
    }
}