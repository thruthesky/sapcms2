<?php
	use sap\Category\Category;
	
	deleteAllCategories();
	createRoot();
	
	
	function createRoot(){
		$categories = 	[					
						'computers',
						'mobile',
						'clothing',
						'pets',
						'books',
						'consumer',
						'home',
						'baby',
						'cars',
						'real estate',
						'services',
						];
		foreach( $categories as $c ){
			$cat = category()->set( $c, $c."_desc" )->save();
			$cat2 = category()->set( $c."_c", $c."_c_desc", $cat->fields['idx'] )->save();			
			//category()->set( $cat2->fields['code']."_child", $cat2->fields['value']."_child_desc", $cat2->fields['idx'] )->save();
		}
	}
	
	function deleteAllCategories(){
		$categories = category()->rows();
		
		foreach( $categories as $c ){
			category()->load( $c['idx'] )->delete();
		}		
	}