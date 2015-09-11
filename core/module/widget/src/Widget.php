<?php
namespace sap\core\widget;

class Widget {
    private static $paths = [];
    private static $ini = [];


    /**
     *
     * Loads and Parses all the ini files of a folder.
     *
     * @param string $base_folder
     *
     * @note it memory caches.
     *
     * @code
     *
     * $a1 = widget()->loadParseIni();
     * $a2 = widget()->loadParseIni("core/module/post/widget/*");
     *
     * @endcode
     * @return array
     */
    public function loadParseIni($base_folder="widget/*") {
        if ( ! isset(self::$paths[$base_folder]) ) {
            $arr = [];
            foreach( glob("$base_folder/*.ini") as $file ) {
                $arr[] = $file;
                $ini = parse_ini_file($file, true);
                $ini['path'] = $file;
                $type = $ini['info']['type'];
                self::$ini[$type][] = $ini;
            }
            self::$paths[$base_folder] = $arr;
        }
        return self::$ini;
    }

}
