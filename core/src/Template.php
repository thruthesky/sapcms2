<?php
namespace sap\src;
use sap\core\System\System;

class Template {


    /**
     * Returns path of template file in theme or module.
     * @param null $filename
     * @param null $module - if it is empty, then it looks for the path in current module.
     * @return bool|string
     */
    public static function script($filename=null, $module=null)
    {
        if ( empty($filename) ) {
            $render = Module::getVariables();
            $filename = isset($render['template']) ? $render['template'] : null;
        }

        if ( $path = Theme::script($filename) ) return $path;
        else {
            return Module::script($filename, $module);
        }
    }

}
