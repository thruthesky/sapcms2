<?php
namespace sap\smsgate;

use sap\src\Request;
use sap\src\Response;

use sap\core\user\User;


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
    private static $idx_message = 0;

    public static function page() {
        Response::render();
    }

    public static function send() {
		$data = [];
        if ( submit() ) {
            $tag = self::getTagFromInput();
            $scheduled = [];
            $error_number = [];
            $numbers = explode("\n", Request::get('numbers'));
            if ( $numbers ) {
                $data = self::scheduleMessage($numbers, request('message'), $tag);
            }
            $data['template'] = 'smsgate.sent';
		}
		$data['page'] = 'send';
        Response::render($data);
    }
	
    public static function api() {
        $method = request('method');
        Response::json(self::$method());
    }
    public static function sendSms() {		
        $id = request('id');
        $password = request('password');
        $message = request('message');
        $number = request('number');
        $tag = self::getTagFromInput();

        if ( ! User::checkIDPassword( $id, $password ) ) return [ 'error'=>-4001, 'Wrong User ID or Password'];

        $data = self::scheduleMessage($number, $message, $tag);

        if ( isset($data['error_number'][0]) ) {
            return $data['error_number'][0];
        }
        else return ['error'=>0];
    }



    public static function scheduleMessage($numbers, $message, $tag='') {

        system_log(__METHOD__);


        if ( empty($numbers) ) {
            return ['error'=>'No number to send(or schedule)'];
        }

        $data = [];
        $data['scheduled'] = [];
        $data['error_number'] = [];
        $q = null;
        if ( ! is_array($numbers) ) $numbers = array($numbers); //
        system_log(__METHOD__);
        //system_log($numbers);

        $_numbers = [];
		$error = [];
        foreach( $numbers as $number ) {
            $adjusted_number = self::adjust_number($number);
            if ( $adjusted_number ) {
                $_numbers[] = $adjusted_number;
            }
            else {               
                $error['message'] = 'Malformed number.';
                $error['number'] = $number;
                $data['error_number'][] = $error;
            }
        }

        if ( !empty( $_numbers ) ) {
            self::createMessage($message);
        }

        foreach( $_numbers as $adjust_number ) {			
			$created = time();
			$priority = request('priority', 0);
			$idx = self::getMessageIdx();
			$q .= "INSERT INTO " . SMS_QUEUE . " (created, idx_message, number, priority, tag) VALUES ($created ,$idx, '$adjust_number', $priority, '$tag');";
			$number_info = [];
			$number_info['message'] = "Successfully added to queue: ";
			$number_info['number'] = $adjust_number;
			$number_info['sms_message'] = $idx;
			$data['scheduled'][] = $number_info;	
        }

        if ( $q ) {
            entity()->beginTransaction();
            entity()->exec($q);
            //system_log($q);
            entity()->commit();
        }
        return $data;
    }


    public static function adjust_number($number)
    {
        $number = trim($number);
        $number = preg_replace("/[^0-9]/", '', $number); // remove all characters
        $number = preg_replace("/^639/", "09", $number);
        $number = preg_replace("/^630/", "0", $number);
        $number = preg_replace("/^63/", "0", $number);

        // make the number 11 digits.
        if ( strlen($number) == 10 && $number[0] == '9' ) $number = "0$number";


        //added by benjamin to make sure that the number is always in correct format...
        //preg_match( '/^09([0-9]+)[0-9]$/',$number, $number );

        //if( !empty( $number ) ) $number = $number[0];
        //else $number = null;

        if ( ! is_numeric($number) ) return false;
        if ( strlen($number) != 11 ) return false;
        if ( $number[0] != '0' ) return false;
        if ( $number[1] != '9' ) return false;
        if ( $number[2] == '0' && $number[3] == '0' ) return false;


        return $number;
    }


    public static function queue() {
        return Response::render( ['page'=>'queue'] );
    }

    public static function success() {
        return Response::render( ['page'=>'success'] );
    }

    public static function fail() {
        return Response::render( ['page'=>'fail'] );
    }

    public static function statistics() {
        return Response::render( ['page'=>'statistics'] );
    }

    public static function delete() {
        $data = [];

        $idx = Request::get('idx');

		$ent = entity( SMS_QUEUE )->load( $idx );
		if( !empty( $ent ) ){
			$data['notice']['type'] = "success";
			$data['notice']['message'] = "Successfully deleted message idx [ $idx ]";
			$ent->delete();
		}
		else{
			$data['notice']['type'] = "error";
			$data['notice']['message'] = "idx [ $idx ] does not exist.";
		}
		$data['page'] = 'queue';
		$data['template'] = 'smsgate.queue';
        
        Response::render($data);
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

        //$sms = entity(QUEUE)->query("ORDER BY priority DESC, stamp_next_send ASC, idx ASC");
        //current time() should be less than stamp_next_send
		$current_time = date( "Hi", time() );
		
		if( $current_time < 700 || $current_time > 2200 ){
			$re['error'] = -410;
            $re['message'] = 'Only send Messages between 7am to 10 pm. Time now is [ '.date( "H:i", time() ).' ] - stop sending message for now...';
			
		}
		else{
			$sms = entity(QUEUE)->query("stamp_next_send <= '".time()."' ORDER BY priority DESC, stamp_next_send ASC, idx ASC");

			if ( $sms ) {
				$sms_tries = $sms->get('no_send_try');
				$idx = $sms->get('idx');
				$number = $sms->get('number');

				if( $sms_tries < 8 ){//including 0 will be a  total of 9 tries...
					$count = entity(QUEUE)->count();
					$re = [
						'error' => 0,
						'idx' => $idx,
						'number' => $number,
						'message' => self::getMessage($sms->get('idx_message')),
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
					$re['error'] = -410;
					$re['message'] = 'Reached the max send attempts for number [ '.$number.'. ] Moving sms_data idx [ '.$idx.' ] to sms_fail';
					entity(SMS_FAILURE)
						->set('number', $sms->get('number'))
						->set('priority', $sms->get('priority'))
						->set('no_send_try', $sms->get('no_send_try'))
						->set('no_fail', $sms->get('no_fail'))
						->set('sender', $sms->get('sender'))
						->set('message', $sms->get('message'))
						->set('reason', $re['message'])
						->set('tag', $sms->get('tag'))
						->save();
					$sms->delete();
				}
			}
			else {
				$re['error'] = -409;
				$re['message'] = 'No more data';
			}
		}
        Response::json($re);
    }

    public static function sender_record_result() {


        $sms = entity(QUEUE)->load(request('idx'));
        if ( empty($sms) ) return Response::json(['error'=>-4040, 'message'=>'SMS does not exists. Maybe wrong idx.']);

        $data = ['error'=>0];

        if ( request('result') == 'Y' ) {
            $entity = entity(SMS_SUCCESS)
                ->set('number', $sms->get('number'))
                ->set('priority', $sms->get('priority'))
                ->set('no_send_try', $sms->get('no_send_try'))
                ->set('no_fail', $sms->get('no_fail'))
                ->set('sender', $sms->get('sender'))
                ->set('idx_message', $sms->get('idx_message'))
                ->set('tag', $sms->get('tag'))
                ->save();
            if ( empty($entity) ) {
                $data['error'] = -40441;
                $data['message'] = "failed on transferring message to success table.";
            }
            $sms->delete();
        }
        else {
            $sms
                ->set('no_fail', $sms->get('no_fail') + 1)
                ->save();
            $data['message'] = 'Increased number of failure';
        }

        Response::json($data);
    }



    public static function getMessage($idx_message)
    {
        return entity(SMS_MESSAGE)->load($idx_message)->get('message');
    }

    private static function getTagFromInput()
    {
        $tag = request('tag');
        if ( empty($tag) ) {
            $tag = "No-Tag:" . login('idx') . ':' . uniqid(time());
        }
        return $tag;
    }

    private static function createMessage($message)
    {
        $message = entity(SMS_MESSAGE)->set('message', $message)->save();
        self::$idx_message = $message->get('idx');
    }


    private static function getMessageIdx()
    {
        return self::$idx_message;
    }
}

