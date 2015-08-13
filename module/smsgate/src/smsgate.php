<?php
namespace sap\smsgate;

use sap\src\Request;
use sap\src\Response;


class smsgate {
	public static $send_delay =	[
						600,//( 60 * 10 ),
						7200,//( 60 * 60 * 2 ),
						14400,//( 60 * 60 * 4 ),
						28800,//( 60 * 60 * 8 ),
						57600,//( 60 * 60 * 16 ),
						115200,//( 60 * 60 * 32 ),
						115200,//( 60 * 60 * 32 ),
						115200,//( 60 * 60 * 32 ),
						];

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

    /**
     *
     *
     * Loads an SMS message and send it to client
     *
     * @Attention Sometimes, mobile client fails to send SMS data but does not report it to server.
     *
     *
     * @todo Move the item to smsgate_failure
     *
     *      - if it has wrong number
     *      - if it has no message.
     *
     *
     * @todo Remove an SMS that has failed for 1 week.
     * @todo Loose-Send
     *      - 1st fail. next send will be after 10 minutes.
     *      - 2nd fail, next send will be after additional 2 hour (from previous stamp)
     *      - 3rd fail, next send will be after additional 4 hour.
     *      - 4th fail, next send will be after additional 8 hour
     *      - 5th fail, next send will be after additional 16 hour
     *      - 6th fail, next send will be after additional 32 hour
     *      - 7th fail, next send will be after additional 32 hour.
     *      - 8th fail, next send will be after additional 32 hour.
     *      - 9th fail. no more try. send it to failture table.
     *
     */
    public static function sender_load_sms_from_queue() {
        $re = [];
        $sms = entity(QUEUE)->query("ORDER BY priority DESC, stamp_next_send ASC, idx ASC");
		
		$sms_tries = $sms->get('no_send_try');
		$idx = $sms->get('idx');
		
		if( $sms_tries < 9 ){
			if ( $sms ) {
				$count = entity(QUEUE)->count();
				$re = [
					'error' => 0,
					'idx' => $idx,
					'number' => $sms->get('number'),
					'message' => $sms->get('message'),
					//'no_send_try' => $sms_tries,
					'total_record' => $count
				];
				$sms
					//->set('stamp_next_send', time() + 60 * 10)
					->set('stamp_next_send', time() + self::$send_delay[ $sms_tries ] )
					->set('no_send_try', $sms_tries + 1)
					->set('sender', request('sender'))
					->save();
			}
			else {
				$re['error'] = -409;
				$re['message'] = 'No more data';
			}
		}
		else{			
			$re['error'] = -410;
			$re['message'] = 'Reached the max send attempts. Deleting idx [ '.$idx.' ] sms data';
			//$sms->delete();
		}
        Response::json($re);
    }

    public static function sender_record_result() {


        $sms = entity(QUEUE)->load(request('idx'));
        if ( empty($sms) ) return Response::json(['error'=>-4040, 'message'=>'SMS does not exists. Maybe wrong idx.']);

        $data = ['error'=>0];

        if ( request('result') == 'Y' ) {
            entity(SMS_SUCCESS)
                ->set('number', $sms->get('number'))
                ->set('priority', $sms->get('priority'))
                ->set('no_send_try', $sms->get('no_send_try'))
                ->set('no_fail', $sms->get('no_fail'))
                ->set('sender', $sms->get('sender'))
                ->set('message', $sms->get('message'))
                ->set('bulk', $sms->get('bulk'))
                ->save();
            $sms->delete();
        }
        else {
            $sms
                ->set('no_fail', $sms->get('no_fail') + 1)
                ->save();
        }

        Response::json($data);
    }

}

