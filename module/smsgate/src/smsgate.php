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
                        ->set('sender', '')
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
        $data['template'] = 'smsgate.queue';
        Response::render($data);
        //return Response::render( $data );
    }

    public static function sender_load_sms_from_queue() {
        $re = [];
        $sms = entity(QUEUE)->query("ORDER BY priority desc");
        if ( $sms ) {
            $count = entity(QUEUE)->count();
            $re = [
                'error' => 0,
                'idx' => $sms->get('idx'),
                'number' => $sms->get('number'),
                'message' => $sms->get('message'),
                'total_record' => $count
            ];
            $sms->set('sender', request('sender'));
        }
        else {
            $re['error'] = -409;
            $re['message'] = 'No more data';
        }
        Response::json($re);
    }

    public static function sender_record_result() {
        $mode = Request::get('mode');
        $idx = Request::get('idx');
        $sms = entity(SMS)->load($idx);

        $data = ['error'=>0];
        if ( $mode == 'success' ) {

        }

        Response::json($data);
    }

}

