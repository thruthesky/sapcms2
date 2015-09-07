<?php
namespace sap\core\data;
use Gregwar\Image\Image;
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
                    $upload['mime'] = $upload['type'];
                    $upload['type'] = request('file_type');
                    $upload['module'] = request('file_module');
                    $upload['idx_target'] = request('file_idx_target', 0);
                    $upload['idx_user'] = login('idx');
                    $upload['finish'] = request('file_finish', 0);
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



    public static function thumbnail() {
        $path = PATH_UPLOAD . '/' . request('file');
        $x = request('x', 120);
        $y = request('y', 120);
        $pi = pathinfo($path);
        $filename = "$pi[filename]-{$x}x$y.jpg";
        $new_path = PATH_CACHE . "/$filename";
        $type = get_mime_type($new_path);

        if ( file_exists($new_path) ) {

        }
        else {
            system_log("Creating new thumbnail: $path");
            Image::open($path)
                ->zoomCrop($x, $y, 'transparent', 'center', 'top')
                ->save($new_path, 'jpg', 100);
        }


        header("Content-Type: $type");
        header("Content-Length: " . filesize($new_path));
        $fp = fopen($new_path, 'rb');
        fpassthru($fp);
        exit;
    }
}
