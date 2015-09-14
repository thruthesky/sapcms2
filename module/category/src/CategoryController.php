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
			self::categoryUpdate();
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
			category()->set('idx_parent', $idx_parent)->set('name', $name)->save();
			//category()->set($name, $description, $idx_parent);
			return Response::redirect('/admin/category/setting');
		}
	}
	
	public static function categoryUpdate(){
		$idx = request('idx');		
		$name = request('name');				
		
		category()
			->load( $idx )			
			->set('name', $name)
			->save();
	}
	
	public static function categoryDelete(){
		$idx = request('idx');	
		$category = category($idx);
		if( empty( $category ) ){
			error(-101,"Incorrect or missing category IDX");
			return Response::render(['template'=>'category.setting']);
		}
		else{
			$children = Category::loadAllChildren( $idx );
			if( empty( $children ) ){
				self::categoryDeleteSubmit();
			}
			else{
				$data = [];
				$data['parent'] = category($idx)->fields;
				$data['children'] = $children;
				return Response::render(['template'=>'category.setting.delete.confirm','data'=>$data]);
			}
		}
	}
	
	public static function categoryDeleteSubmit(){
		$idx = request('idx');
		$children = Category::loadAllChildren( $idx );
		
		if( !empty( $children ) ){
			foreach( $children as $c ){
				category()->load( $c['idx'] )->delete();
			}
		}
		category()->load( $idx )->delete();
		return Response::render(['template'=>'category.setting']);
	}
}
