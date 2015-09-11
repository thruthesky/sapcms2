<?php
namespace sap\Category;

use sap\src\Meta;

class Category extends Meta {
    public function __construct() {
        parent::__construct(CATEGORY_META);
    }
	
	/*
	*just returns the reverse version of loadParents();
	*/
	public static function getParents($idx) {
		return array_reverse( self::loadParents( $idx ) );
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
	
	/*
	*returns parent from highest depth to lowest
	*/
	public static function loadParents($idx) {
        if ( empty($idx) ) return [];
		$rows = [];
        $category = category()->load($idx);
        if ( !empty( $category ) ) {
			$category = $category->fields;
            $idx = $category['idx_target'];						
            $rows[ $idx ] = $category;			
            $pid = category()->row("idx = $idx");	
		
            if ( !empty( $pid ) ) {
                $rets = self::loadParents( $pid['idx'] );
                $rows = $rows + $rets;
            }					
            return $rows;
        }
        else return [];
    }
}

