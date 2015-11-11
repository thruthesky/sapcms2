<?php
namespace sap\englishworld;
use sap\src\Response;

//use sap\core\message\Message;

class Englishworld {

	public static function introduction( $num ){
		$function_name = ( __FUNCTION__ );
		$page = "subpage.".$function_name.$num;
		return Response::render([
            'template'=>$page,
            'page'=>$function_name,			
        ]);
	}

	public static function course( $num ){
		$function_name = ( __FUNCTION__ );
		$page = "subpage.".$function_name.$num;
		return Response::render([
            'template'=>$page,
            'page'=>$function_name,			
        ]);
	}

	public static function junior( $num ){
		$function_name = ( __FUNCTION__ );
		$page = "subpage.".$function_name.$num;
		return Response::render([
            'template'=>$page,
            'page'=>$function_name,			
        ]);
	}

	public static function camp( $num ){
		$function_name = ( __FUNCTION__ );
		$page = "subpage.".$function_name.$num;
		return Response::render([
            'template'=>$page,
            'page'=>$function_name,			
        ]);
	}
	
	public static function gallery( $num ){
		$function_name = ( __FUNCTION__ );
		$page = "subpage.".$function_name.$num;
		return Response::render([
            'template'=>$page,
            'page'=>$function_name,			
        ]);
	}
	
}
