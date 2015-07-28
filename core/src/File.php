<?php
namespace sap\core;
class File
{

    /**
     *
     * @note saves associative variables into a file.
     * @use use it to create configuration file.
     *
     *
     * @param $path
     * @param $vars
     * @return int
     */
    public static function save_in_php($path, $vars)
    {
        $data = "<?php" . PHP_EOL;
        foreach ( $vars as $k => $v ) {
            $k = str_replace('-', '_', $k);
            $data .= '$'.$k . " = \"$v\";" . PHP_EOL;
        }
        return self::save($path, $data);
    }

    /**
     *
     * Save data into a file.
     *
     * @note this function return FALSE on failure, otherwise 0 or number of bytes written.
     * @Attention The return value of this function is different from file_up_content
     *
     * @param $path
     * @param $data
     * @return int
     * error code if there is error.
     *
     */
    public static function save ($path, $data) {
        $re = file_put_contents ( $path, $data );
        if ( $re === false ) return ERROR_FAIL_TO_SAVE;
        return $re;
    }

    /**
     * @param $path
     * @param $data
     * @return int
     */
    public static function append($path, $data) {
        $re = file_put_contents ( $path, $data, FILE_APPEND );
        if ( $re === false ) return ERROR_FAIL_TO_SAVE;
        return $re;
    }
}
