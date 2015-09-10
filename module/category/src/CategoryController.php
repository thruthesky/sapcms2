<?php
namespace sap\category;
use sap\src\Response;


/**
 *
 *
 *
 */
class CategoryController {

    public static function setting() {
        return Response::render(['template'=>'category.setting']);
    }

    public static function settingSubmit() {
        $name = request('name');
        $description = request('description');
        $category = category($name);
        if ( $category ) {
            error(-80801, "Category name - $name - exists!");
            return Response::render(['template'=>'category.setting']);
        }
        else {
            category()->set($name, $description);
            return Response::redirect('/admin/category/setting');
        }


    }


}
