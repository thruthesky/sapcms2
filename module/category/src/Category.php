<?php
namespace sap\Category;

use sap\src\Meta;

class Category extends Meta {
    public function __construct() {
        parent::__construct(CATEGORY_META);
    }

	public static function loadAllChildren($parent_id, $depth = 0) {//$delete temporary
		$children = category()->rows( "idx_target = '$parent_id'" );
		$rows = [];
		foreach( $children as $c ){	
			$item = [];
			$idx = $c['idx'];
			$rows[ $idx ] = $c;			
			$rows[ $idx ]['depth'] = $depth + 1;
			$returns = self::loadAllChildren( $idx, $depth + 1 );
			if( $returns ) $rows = $rows + $returns;			
			$rows[ $idx ]['no_of_children'] = count( $returns );
		}
		
		return $rows;
	}
}

