<?php
namespace sap\smsgate;

use sap\src\Request;
use sap\src\Response;

class smsgate {
    public static function page() {
        Response::render();
    }

    public static function send() {
        if ( submit() ) {
            $scheduled = [];
            $numbers = explode("\n", Request::get('numbers'));
            if ( $numbers ) {
                foreach( $numbers as $number ) {
                    $number = trim($number);
                    if ( empty($number) ) continue;
                    entity(QUEUE)
                        ->create()
                        ->set('number', $number)
                        ->set('message', Request::get('message'))
                        ->set('priority', 9)
                        ->set('user_agent', user_agent())
                        ->save();
                    $scheduled[] = $number;
                }
            }
            Response::render(['template'=>'smsgate.sent', 'scheduled'=>$scheduled]);
        }
        else {
            Response::render();
        }
    }

    public static function queue() {
        return Response::render();
    }
	
    public static function delete() {
		$data = [];
	
		$idx = Request::get('idx');		
		$ent = entity(QUEUE)->load( $idx );
		if( !empty( $ent ) ){
			$data['notice']['type'] = "success";
			$data['notice']['message'] = "Successfully deleted message idx [ $idx ]";
			$ent->delete();
		}
		else{
			$data['notice']['type'] = "error";
			$data['notice']['message'] = "idx [ $idx ] does not exist.";
		}
		
		//redirect??
		//$url = "/smsgate/list/queue?page_no=".Request::get('page_no');
		//return Response::redirect( $url );
		//or show only..?
        return Response::render( $data );
    }

    public static function load_a_message() {
        $row = db_row('sms_extract_numbers');
        Response::json($row);
    }

}

