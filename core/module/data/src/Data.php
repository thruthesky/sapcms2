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


    /**
     * @param array $options
     *
     *      - $options['path'] - is the file path to add
     *      - $options['idx_target'] - is the target object
     *      - $option['idx_user'] - is the user.
     *      - $options['module'] - is the module
     *      - $options['type'] - is the type
     *      - $options['finish'] -
     *      - $option['form_name'] - is the form input box variable name
     *      - Others are automatically set.
     *
     * @Attention Call this method with full option values.
     * name, name_saved, form_name, size, mime, module, type, idx_target, idx_user, finish
     * @return $this|bool
     */
    public function saveFile(array $options) {
        $pi = pathinfo($options['path']);
        $filename = $pi['basename'];
        $name = data()->getPossibleFilenameToSave($filename);
        //system_log("name:$name");
        $path = PATH_UPLOAD . DIRECTORY_SEPARATOR . $name;
        //system_log("path to save: $path");
        if ( copy($options['path'], $path) ) {
            $options['mime'] = get_mime_type($path);
            $options['size'] = filesize($path);
            $options['name'] = $filename;
            $options['name_saved'] = $name;
            return data()->record($options);
        }
        else {
            //system_log("ERROR: move_uploaded_file($options[path], $path)");
            return FALSE;
        }
    }
    /**
     *
     * @param $upload
     * @return $this
     * @code
     * $upload['name_saved'] = $name;
    $upload['mime'] = $upload['type'];
    $upload['type'] = request('file_type');
    $upload['module'] = request('file_module');
    $upload['idx_target'] = request('file_idx_target', 0);
    $upload['idx_user'] = login('idx');
    $upload['finish'] = request('file_finish', 0);
    $data = data()->record($upload);
     * @endcode
     *
     */
    public function record(&$upload)
    {
        $this->deleteUnfinishedFiles();
        if ( isset($upload['name']) ) $this->set('name', $upload['name']);
        if ( isset($upload['name_saved']) ) $this->set('name_saved', $upload['name_saved']);
        if ( isset($upload['form_name']) ) $this->set('form_name', $upload['form_name']);
        if ( isset($upload['size']) ) $this->set('size', $upload['size']);
        if ( isset($upload['mime']) ) $this->set('mime', $upload['mime']);
        if ( isset($upload['module']) ) $this->set('module', $upload['module']);
        if ( isset($upload['type']) ) $this->set('type', $upload['type']);
        if ( isset($upload['idx_target']) ) $this->set('idx_target', $upload['idx_target']);
        if ( isset($upload['idx_user']) ) $this->set('idx_user', $upload['idx_user']);
        if ( isset($upload['finish']) ) $this->set('finish', $upload['finish']);

        return $this->save();
    }

    public function url()
    {
        return sysconfig(URL_SITE) . URL_PATH_UPLOAD . '/' . $this->get('name_saved');
    }

    public function urlThumbnail($x=160, $y=160) {
        return sysconfig(URL_SITE) . 'image/thumbnail?file=' . $this->get('name_saved') . "&x={$x}&y=$y";
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
        if ( empty($name) ) {
            return null;
        }
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
        system_log(__METHOD__);
        $path = $this->path();
        if ( empty($path) ) {
            system_log("path is empty");
            return error(-51002, "Path is empty");
        }
        if ( unlink($path) ) {
            system_log("deleted. path:$path");
            $this->delete();
            return OK;
        }
        else {
            return error(-51000, "Failed on delete file");
        }
    }

    /**
     *
     * Returns Array of file entities BASED ON Database::row() conditioin
     * @param $cond - Same as Database::row()
     * @return array - Entities
     *
     * @code
     *
     *
     * $files = $this->files("created>$stamp AND finished=0", DATA_TABLE);
     * foreach( $files as $file ) {
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


    /**
     * @param $module
     * @param $type
     * @param $idx_target
     * @param null $form_name
     * @return array
     *
     * @code
     *      $files = data()->loadBy('post', 'file', post_data()->getCurrent()->get('idx'));
     *      $files = data()->loadBy('post', 'file', post_data()->getCurrent()->get('idx'), 'books');
     * @endcode
     *
     */
    public function loadBy($module, $type, $idx_target, $form_name=null) {
        $cond = "module='$module' AND type='$type' AND idx_target=$idx_target";
        if ( $form_name ) $cond .= " AND form_name='$form_name'";
        return $this->files($cond);
    }


}