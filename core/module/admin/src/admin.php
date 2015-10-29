<?php
namespace sap\core\admin;

use sap\src\Response;

class admin {
    public static function page() {
		if( login('id') != 'admin' ){
			//added by benjamin to redirect non admin users
			Response::redirect('/');
		}
		else Response::renderSystemLayout(['template'=>'index']);
    }

    public static function database_information() {
        Response::renderSystemLayout(['template'=>'database-information']);
    }

}
