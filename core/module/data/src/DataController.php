<?php
namespace sap\core\data;
use sap\src\Response;

class DataController
{

    /**
     * @return array
     *
     *  - If there is error,
     *      ['error'] - INT
     *      ['message'] - Error message
     */
    public static function upload() {
        system_log(__METHOD__);

        $uploads = self::multipleFileUploadInfo();
        system_log($uploads);

        $re = [];
        foreach( $uploads as $upload ) {
            system_log("name: $upload[name], tmp_name: $upload[tmp_name]");
            if ( empty($upload['error'])  ) {
                $name = data()->getPossibleFilenameToSave($upload['name']);
                system_log("name:$name");
                $path = PATH_UPLOAD . DIRECTORY_SEPARATOR . $name;
                system_log("path to save: $path");
                if ( ! move_uploaded_file($upload["tmp_name"], $path) ) {
                    system_log("ERROR: move_uploaded_file($upload[tmp_name], $path)");
                    $upload['message'] = error_get_last_message();
                    continue;
                }
                else {
                    $upload['name_saved'] = $name;
                    $data = data()->record($upload);
                    $upload['idx'] = $data->get('idx');
                    $upload['url'] = $data->url();
                }
            }
            else {
                system_log("ERROR: $upload[name]");
                $upload['message'] = error_get_last_message();
            }
            $re[] = $upload;
        }
        return Response::json($re);
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
