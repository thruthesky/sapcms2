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
		$data =[];
		$data['input'] = request();
		if( !empty( $data['input']['idx'] ) ) $data['category'] = category()->load( $data['input']['idx'] );
				
        return Response::render(['template'=>'category.setting','data'=>$data]);
    }

    public static function settingSubmit() {
		//if has IDX then it is not create
		$idx = request('idx');
		if( empty( $idx ) ) self::categoryCreate();
		else {
			if( request('action') == 'delete' ) self::categoryDelete();
			else self::categoryUpdate();
		}
		return Response::render(['template'=>'category.setting',]);
    }
	
	public static function categoryCreate(){
		$name = request('name');
		$description = request('description');
		$category = category($name);
		if ( $category ) {
			error(-80801, "Category name - $name - exists!");
			return Response::render(['template'=>'category.setting']);
		}
		else {
			$idx_parent = request('idx_parent');
			if( empty( $idx_parent ) ) $idx_parent = 0;
			category()->set($name, $description, $idx_parent);
			return Response::redirect('/admin/category/setting');
		}
	}

	public static function categoryUpdate(){
		$idx = request('idx');
		$name = request('name');
		$description = request('description');
		$c = category()
				->set($name,$description)
				->save();
	}
	
	public static function categoryDelete(){
		$idx = request('idx');		
		category($idx)->delete();
	}
}
