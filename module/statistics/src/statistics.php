<?php
namespace sap\statistics;
use sap\src\Response;

use sap\core\user\User;

class Statistics {
	public static function index() {		
        return Response::renderSystemLayout([
            'template'=>'statistics.layout',
            'page'=>'statistics.admin.index',
        ]);
    }
}