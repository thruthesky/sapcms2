<?php
namespace sap\wooreeedu;
use sap\src\Response;

use sap\core\message\Message;

class Wooreeedu {
	public static function course(){
		return Response::render([
            'template'=>'course',
            'page'=>'course',
            //'config' => $config,
        ]);
	}
	
	public static function lecture(){
		return Response::render([
            'template'=>'lecture',
            'page'=>'course',
            //'config' => $config,
        ]);
	}
	
	public static function trainingCost(){
		return Response::render([
            'template'=>'trainingCost',
            'page'=>'course',
            //'config' => $config,
        ]);
	}
	
	public static function junior(){
		return Response::render([
            'template'=>'junior',
            'page'=>'junior',
            //'config' => $config,
        ]);
	}
	
	public static function juniorEarlyStudy(){
		return Response::render([
            'template'=>'juniorEarlyStudy',
            'page'=>'junior',
            //'config' => $config,
        ]);
	}
	
	public static function advantagesInPH(){
		return Response::render([
            'template'=>'advantagesInPH',
            'page'=>'junior',
            //'config' => $config,
        ]);
	}
	
	public static function earlyCost(){
		return Response::render([
            'template'=>'earlyCost',
            'page'=>'junior',
            //'config' => $config,
        ]);
	}
	
	public static function recommended(){
		return Response::render([
            'template'=>'recommended',
            'page'=>'junior',
            //'config' => $config,
        ]);
	}
	
	public static function camp(){
		return Response::render([
            'template'=>'camp',
            'page'=>'camp',
            //'config' => $config,
        ]);
	}
	public static function campInformation(){
		return Response::render([
            'template'=>'campInformation',
            'page'=>'camp',
            //'config' => $config,
        ]);
	}
	public static function schedule(){
		return Response::render([
            'template'=>'schedule',
            'page'=>'camp',
            //'config' => $config,
        ]);
	}
	public static function preparation(){
		return Response::render([
            'template'=>'preparation',
            'page'=>'camp',
            //'config' => $config,
        ]);
	}
	public static function weekendActivities(){
		return Response::render([
            'template'=>'weekendActivities',
            'page'=>'camp',
            //'config' => $config,
        ]);
	}
	public static function requirement(){
		return Response::render([
            'template'=>'requirement',
            'page'=>'camp',
            //'config' => $config,
        ]);
	}
	
	public static function gallery(){
		return Response::render([
            'template'=>'gallery',
            'page'=>'gallery',
            //'config' => $config,
        ]);
	}
	public static function popsong(){
		return Response::render([
            'template'=>'popsong',
            'page'=>'gallery',
            //'config' => $config,
        ]);
	}
	public static function tripping(){
		return Response::render([
            'template'=>'tripping',
            'page'=>'gallery',
            //'config' => $config,
        ]);
	}
	public static function speech(){
		return Response::render([
            'template'=>'speech',
            'page'=>'gallery',
            //'config' => $config,
        ]);
	}
	public static function xmas(){
		return Response::render([
            'template'=>'xmas',
            'page'=>'gallery',
            //'config' => $config,
        ]);
	}
	public static function seminar(){
		return Response::render([
            'template'=>'seminar',
            'page'=>'gallery',
            //'config' => $config,
        ]);
	}
	
	public static function videoEnglish(){
		return Response::render([
            'template'=>'videoEnglish',
            'page'=>'videoEnglish',
            //'config' => $config,
        ]);
	}
	
	
	
}
