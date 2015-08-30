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
        if ( file_exists($this->path($name)) ) {
            $pi = pathinfo($name);
            for ( $i=1; $i<10000; $i++ ) {
                $name = $pi['filename'] . "($i)." . $pi['extension'];
                if ( ! file_exists($this->path($name)) ) break;
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


    public function path($name)
    {
        return PATH_UPLOAD . DIRECTORY_SEPARATOR . $name;
    }
}