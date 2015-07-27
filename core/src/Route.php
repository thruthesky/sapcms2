<?php
class Route {
    public static function create($module, $class, $method='defaultController') {
        return '?' . HTTP_VAR_ROUTE . "=$module.$class.$method";
    }
}