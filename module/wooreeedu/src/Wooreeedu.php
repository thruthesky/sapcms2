<?php
namespace sap\wooreeedu;
use sap\src\Response;

use sap\core\message\Message;

class Wooreeedu {
		
	public static function introduction(){
		return Response::render([
            'template'=>'introduction',
            'page'=>'introduction',
			'header_text'=>'ABOUT US',
            //'config' => $config,
        ]);
	}
	public static function multiLanguage(){
		return Response::render([
            'template'=>'multiLanguage',
            'page'=>'introduction',
			'header_text'=>'ABOUT US',
            //'config' => $config,
        ]);
	}
	public static function multiLanguage_2(){
		return Response::render([
            'template'=>'multiLanguage_2',
            'page'=>'introduction',
			'header_text'=>'ABOUT US',
            //'config' => $config,
        ]);
	}
	public static function schoolDormitory(){
		return Response::render([
            'template'=>'schoolDormitory',
            'page'=>'introduction',
			'header_text'=>'ABOUT US',
            //'config' => $config,
        ]);
	}
	
	public static function course(){
		return Response::render([
            'template'=>'course',
            'page'=>'course',
			'header_text'=>'COURSE',
            //'config' => $config,
        ]);
	}
	
	public static function lecture(){
		return Response::render([
            'template'=>'lecture',
            'page'=>'course',
			'header_text'=>'COURSE',
            //'config' => $config,
        ]);
	}
	
	public static function trainingCost(){
		return Response::render([
            'template'=>'trainingCost',
            'page'=>'course',
			'header_text'=>'COURSE',
            //'config' => $config,
        ]);
	}
	
	public static function junior(){
		return Response::render([
            'template'=>'junior',
            'page'=>'junior',
			'header_text'=>'JUNIOR',
            //'config' => $config,
        ]);
	}
	
	public static function juniorEarlyStudy(){
		return Response::render([
            'template'=>'juniorEarlyStudy',
            'page'=>'junior',
			'header_text'=>'JUNIOR',
            //'config' => $config,
        ]);
	}
	
	public static function advantagesInPH(){
		return Response::render([
            'template'=>'advantagesInPH',
            'page'=>'junior',
			'header_text'=>'JUNIOR',
            //'config' => $config,
        ]);
	}
	
	public static function earlyCost(){
		return Response::render([
            'template'=>'earlyCost',
            'page'=>'junior',
			'header_text'=>'JUNIOR',
            //'config' => $config,
        ]);
	}
	
	public static function recommended(){
		return Response::render([
            'template'=>'recommended',
            'page'=>'junior',
			'header_text'=>'JUNIOR',
            //'config' => $config,
        ]);
	}
	
	public static function camp(){
		return Response::render([
            'template'=>'camp',
            'page'=>'camp',
			'header_text'=>'CAMP',
            //'config' => $config,
        ]);
	}
	public static function campInformation(){
		return Response::render([
            'template'=>'campInformation',
            'page'=>'camp',
			'header_text'=>'CAMP',
            //'config' => $config,
        ]);
	}
	public static function schedule(){
		return Response::render([
            'template'=>'schedule',
            'page'=>'camp',
			'header_text'=>'CAMP',
            //'config' => $config,
        ]);
	}
	public static function preparation(){
		return Response::render([
            'template'=>'preparation',
            'page'=>'camp',
			'header_text'=>'CAMP',
            //'config' => $config,
        ]);
	}
	public static function weekendActivities(){
		return Response::render([
            'template'=>'weekendActivities',
            'page'=>'camp',
			'header_text'=>'CAMP',
            //'config' => $config,
        ]);
	}
	public static function requirement(){
		return Response::render([
            'template'=>'requirement',
            'page'=>'camp',
			'header_text'=>'CAMP',
            //'config' => $config,
        ]);
	}
	
	public static function gallery(){
		return Response::render([
            'template'=>'gallery',
            'page'=>'gallery',
			'header_text'=>'GALLERY',
            //'config' => $config,
        ]);
	}
	public static function popsong(){
		return Response::render([
            'template'=>'popsong',
            'page'=>'gallery',
			'header_text'=>'GALLERY',
            //'config' => $config,
        ]);
	}
	public static function tripping(){
		return Response::render([
            'template'=>'tripping',
            'page'=>'gallery',
			'header_text'=>'GALLERY',
            //'config' => $config,
        ]);
	}
	public static function speech(){
		return Response::render([
            'template'=>'speech',
            'page'=>'gallery',
			'header_text'=>'GALLERY',
            //'config' => $config,
        ]);
	}
	public static function xmas(){
		return Response::render([
            'template'=>'xmas',
            'page'=>'gallery',
			'header_text'=>'GALLERY',
            //'config' => $config,
        ]);
	}
	public static function seminar(){
		return Response::render([
            'template'=>'seminar',
            'page'=>'gallery',
			'header_text'=>'GALLERY',
            //'config' => $config,
        ]);
	}
	
	public static function videoEnglish(){
		return Response::render([
            'template'=>'videoEnglish',
            'page'=>'videoEnglish',
			'header_text'=>'VIDEO ENGLISH',
            //'config' => $config,
        ]);
	}
	
	public static function great(){
		return Response::render([
            'template'=>'great',
            'page'=>'videoEnglish',
			'header_text'=>'VIDEO ENGLISH',
            //'config' => $config,
        ]);
	}
	
	public static function pricing(){
		return Response::render([
            'template'=>'pricing',
            'page'=>'studyAbroad',
			'header_text'=>'STUDY ABROAD',
            //'config' => $config,
        ]);
	}
	
	public static function priceUs(){
		return Response::render([
            'template'=>'priceUs',
            'page'=>'studyAbroad',
			'header_text'=>'STUDY ABROAD',
            //'config' => $config,
        ]);
	}
	
	public static function priceChinese(){
		return Response::render([
            'template'=>'priceChinese',
            'page'=>'studyAbroad',
			'header_text'=>'STUDY ABROAD',
            //'config' => $config,
        ]);
	}
	
	public static function diploma(){
		return Response::render([
            'template'=>'diploma',
            'page'=>'studyAbroad',
			'header_text'=>'STUDY ABROAD',
            //'config' => $config,
        ]);
	}
	
	public static function paymentInfo(){
		return Response::render([
            'template'=>'paymentInfo',
            'page'=>'paymentInfo',
			'header_text'=>'PAYMENT INFO',
            //'config' => $config,
        ]);
	}
	
	
	public static function messageSendSubmit(){
		$name = request('name');
		$email = request('email');
		$title = request('title');
		$content = request('content');
		
		$error = null;
		
		$new_content = 	nl2br("	Contact Us 
								
								Name: $name
								Email: $email
								$content
								");
		$user_idx = login('idx');
		if( empty( $user_idx ) ) $user_idx = 0;
		
		if( empty( $content ) ) $error = "Contact us content cannot be empty!";
		
		$message_entity = message()->set('idx_from',$user_idx) //anon
				->set('idx_to', 1) //admin
				->set('title', $title)
				->set('content', $new_content);				
		
		
		if( empty( $error ) ){
			$message_entity->save();
			echo "<script>alert('Succesfully sent the message!');</script>";
			Response::redirect('/');
		}
		else{
			echo "<script>alert('".$error."');</script>";				
			return Response::render([
				'template'=>'front.page',
			]);
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**/
	public static function subPageIntroduction( $num ){
		$function_name = "introduction";
		$page = "subpage.".$function_name.$num;
		return Response::render([
            'template'=>$page,
            'page'=>$function_name,			
        ]);
	}

	public static function subPageCourse( $num ){
		$function_name = "course";
		$page = "subpage.".$function_name.$num;
		return Response::render([
            'template'=>$page,
            'page'=>$function_name,			
        ]);
	}

	public static function subPageJunior( $num ){
		$function_name = "junior";
		$page = "subpage.".$function_name.$num;
		return Response::render([
            'template'=>$page,
            'page'=>$function_name,			
        ]);
	}

	public static function subPageCamp( $num ){
		$function_name = "camp";
		$page = "subpage.".$function_name.$num;
		return Response::render([
            'template'=>$page,
            'page'=>$function_name,			
        ]);
	}
	
	public static function subPageGallery( $num ){
		$function_name = "gallery";
		$page = "subpage.".$function_name.$num;
		return Response::render([
            'template'=>$page,
            'page'=>$function_name,			
        ]);
	}
}
