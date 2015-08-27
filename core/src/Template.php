<?php
namespace sap\src;
use sap\core\System\System;

class Template {

    public static function script($filename=null)
    {
        if ( empty($filename) ) {
            $render = Module::getVariables();
            $filename = isset($render['template']) ? $render['template'] : null;
        }
        if ( $path = Theme::script($filename) ) return $path;
        else return Module::script($filename);
    }

}
