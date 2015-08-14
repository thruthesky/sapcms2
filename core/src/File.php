<?php
namespace sap\src;
define('ERROR_FILE_EXISTS', -402001);
define('ERROR_CREATE_DIR', -402002);
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
     * - error code if there is error.
     * - or bytes of written
     *
     */
    public static function save ($path, $data) {
        $re = file_put_contents ( $path, $data );
        if ( $re === false ) return ERROR_FAIL_TO_SAVE;
        return $re;
    }

    /**
     *
     * @Attention It crates the file if the file does not exists.
     *
     * @param $path
     * @param $data
     * @return int
     */
    public static function append($path, $data) {
        $re = file_put_contents ( $path, $data, FILE_APPEND );
        if ( $re === false ) return ERROR_FAIL_TO_SAVE;
        return $re;
    }

    /**
     * @param $path
     * @param string $mode
     * @param bool|true $recursive
     * @return int
     */
    public static function createDir($path, $mode="0777", $recursive=true)
    {
        if ( file_exists($path) ) {
            return ERROR_FILE_EXISTS;
        }
        else {
	$old = umask(0);
    $re = mkdir($path, $mode, $recursive);
	umask($old);
            if ( $re ) return 0;
            else return ERROR_CREATE_DIR;
        }
    }

    /**
     *
     * Alias of unlink()
     *
     * @param $path
     * @return bool
     *
     *      - TRUE on success deleting
     *      - FALSE if fail to delete.
     *
     */
    public static function delete($path)
    {
        return @unlink($path);
    }

    public static function read($path) {
        $content = file_get_contents($path);
        if ( $content === false ) return ERROR_FAIL_TO_READ;
        return $content;
    }
}
