<?php
namespace sap\wooreeedu;
use sap\src\Response;

use sap\core\message\Message;

class Wooreeedu {
	public static function schedule(){
		return Response::render([
            'template'=>'schedule',
            'page'=>'schedule',
            //'config' => $config,
        ]);
	}
	
	public static function trainingCost(){
		return Response::render([
            'template'=>'trainingCost',
            'page'=>'cost',
            //'config' => $config,
        ]);
	}
}
