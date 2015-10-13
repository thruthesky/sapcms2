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
        sys()->log(__METHOD__);

        $uploads = Data::multipleFileUploadInfo();

        sys()->log("uploaded files:");
        sys()->log($uploads);

        $re = [];
        foreach( $uploads as $upload ) {
            system_log("name: $upload[name], tmp_name: $upload[tmp_name]");
            if ( empty($upload['error'])  ) {
                $name = data()->getPossibleFilenameToSave($upload);
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
                    if ( request('file_unique') ) {
                        $files = data()->loadBy($upload['module'], $upload['type'], $upload['idx_target']);
                        foreach( $files as $file ) {
                            $file->deleteFile();
                        }
                    }
                    $data = data()->record($upload);
                    $upload['idx'] = $data->get('idx');
                    $upload['url'] = $data->url();
                    $upload['urlThumbnail'] = $data->urlThumbnail(request('file_image_thumbnail_width',160), request('file_image_thumbnail_height', 160));
                }
            }
            else {
                if ( $upload['error'] == UPLOAD_ERR_INI_SIZE ) $upload['message'] = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                else if ( $upload['error'] == UPLOAD_ERR_FORM_SIZE ) $upload['message'] = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
                else if ( $upload['error'] == UPLOAD_ERR_PARTIAL ) $upload['message'] = " The uploaded file was only partially uploaded.";
                else if ( $upload['error'] == UPLOAD_ERR_NO_FILE ) $upload['message'] = " No file was uploaded.";
                else if ( $upload['error'] == UPLOAD_ERR_NO_TMP_DIR ) $upload['message'] = "Missing a temporary folder.";
                else if ( $upload['error'] == UPLOAD_ERR_CANT_WRITE ) $upload['message'] = "Failed to write file to disk.";
                else if ( $upload['error'] == UPLOAD_ERR_EXTENSION ) $upload['message'] = "A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.";
                else {
                    $upload['message'] = error_get_last_message();
                }
                sys()->log("ERROR: $upload[name]");
            }
            $re[] = $upload;
        }
        sys()->log("return to client:");
        sys()->log($re);
		//return di( $re );
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
            $image = Image::open($path);
            $image->setCacheDir(PATH_CACHE)
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
