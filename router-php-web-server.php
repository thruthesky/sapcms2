<?php
if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}
else {
    define("ROUTER_PHP", true);
    include __DIR__ . '/index.php';
}
