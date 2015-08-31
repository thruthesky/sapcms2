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

        $uploads = Data::multipleFileUploadInfo();
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

    public static function delete() {
        $idx = request('idx');
        $re = ['idx'=>$idx];
        $data = data($idx);
        if ( $data ) {
            $re['error'] = data($idx)->deleteFile();
            if ( $re['error'] ) $re['message'] = getErrorString();
        }
        else {
            $re['error'] = -51001;
            $re['message'] = "File does not exists.";
        }

        return Response::json($re);
    }


}
