<?php
namespace sap\core\data;
use sap\src\Entity;


/**
 *
 *
 */
class Data extends Entity
{

    public function __construct() {
        parent::__construct(DATA_TABLE);
    }


    public function record($upload)
    {
        $this->deleteUnfinishedFiles();
        return $this
            ->set('name', $upload['name'])
            ->set('name_saved', $upload['name_saved'])
            ->set('form_name', $upload['form_name'])
            ->set('size', $upload['size'])
            ->set('type', $upload['type'])
            ->set('module', request('file_module'))
            ->set('type', request('file_type'))
            ->set('idx_target', request('file_idx_target', 0))
            ->set('idx_user', login('idx', 0))
            ->set('finish', request('file_finish', 0))
            ->save();
    }


    public function url()
    {
        return sysconfig(URL_SITE) . URL_PATH_UPLOAD . '/' . $this->get('name_saved');
    }

    /**
     *
     * Returns a filename.
     *
     *  - if file name exists on hard disk, it adds a number at the end and increase by 1 until there is no file which has same name.
     *
     * @param $name
     * @return string
     */
    public function getPossibleFilenameToSave($name) {
        $name = self::makeSafeFilename($name);
        if ( is_file($this->path($name)) ) {
            $pi = pathinfo($name);
            for ( $i=1; $i<10000; $i++ ) {
                $name = $pi['filename'] . "($i)." . $pi['extension'];
                if ( ! is_file($this->path($name)) ) break;
            }
        }
        return $name;
    }

    public static function makeSafeFilename($file)
    {
        // Remove any trailing dots, as those aren't ever valid file names.
        $file = rtrim($file, '.');
        $file = str_replace(' ', '-', $file);
        $regex = array('#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#');
        $file = trim(preg_replace($regex, '', $file));
        return $file;

    }


    /**
     *
     * Return file path.
     *
     * @param null $name - if it is null, then it uses $this->name_saved
     * @return string
     */
    public function path($name=null)
    {
        if ( empty($name) ) $name = $this->get('name_saved');
        return PATH_UPLOAD . DIRECTORY_SEPARATOR . $name;
    }

    private function deleteUnfinishedFiles()
    {
        $stamp = time() - INTERVAL_DELETE_UNFINISHED_FILE;
        $files = $this->files("created<$stamp AND finish=0", DATA_TABLE);
        foreach( $files as $file ) {
            $path = $file->path();
            system_log("delete: file: " . $file->get('idx') . " path:$path");
            if ( unlink($path) ) {
                $file->delete();
            }
            else {
                // error
                system_log("ERROR - FAILED ON DELETING FILE : $path");
            }
        }
    }

    public function deleteFile() {
        $path = $this->path();
        if ( empty($path) ) return error(-51002, "Path is empty");
        system_log(__METHOD__);
        system_log("path:$path");
        if ( unlink($path) ) {
            $this->delete();
            return OK;
        }
        else {
            return error(-51000, "Failed on delete file");
        }
    }


    /**
     *
     * Returns Array of file entities.
     * @param $cond - Same as Database::row()
     * @return array - Entities
     *
     * @code
     *

    $files = $this->files("created>$stamp AND finished=0", DATA_TABLE);
    foreach( $files as $file ) {
     *
     * @endcode
     */
    public function files($cond) {
        $idxes = $this->indexes($cond);
        $files = [];
        if ( $idxes ) {
            foreach( $idxes as $idx ) {
                $files[] = data()->load($idx);
            }
        }
        return $files;
    }



    public static function multipleFileUploadInfo()
    {
        $re = [];
        foreach ($_FILES as $k => $v) {
            $f = array();
            $f['form_name'] = $k;
            if (is_array($v['name'])) {
                for ($i = 0; $i < count($v['name']); $i++) {
                    $f['name'] = $v['name'][$i];
                    $f['type'] = $v['type'][$i];
                    $f['tmp_name'] = $v['tmp_name'][$i];
                    $f['error'] = $v['error'][$i];
                    $f['size'] = $v['size'][$i];
                    $re[] = $f;
                }
            }
            else {
                $f['name'] = $v['name'];
                $f['type'] = $v['type'];
                $f['tmp_name'] = $v['tmp_name'];
                $f['error'] = $v['error'];
                $f['size'] = $v['size'];
                $re[] = $f;
            }
        }
        return $re;
    }
}