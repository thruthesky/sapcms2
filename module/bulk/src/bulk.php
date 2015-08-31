<?php
namespace sap\bulk;


use sap\smsgate\smsgate;
use sap\src\Response;
use sap\src\Request;


class bulk {
    public static function index() {
        return Response::render();
    }
    public static function create() {
        if ( submit() ) {			
            //di( entity(BULK_DATA)->count() );
			$idx = Request::get('idx');
			if( !empty( $idx ) ){
				$bulk = entity(BULK)
							->load( $idx )
							->set('name', request('name'))
							->set('message', request('message'))
							->set('number', request('number'))
							->save();
			}
			else{
				entity(BULK)
					->set('name', request('name'))
					->set('message', request('message'))
					->set('number', request('number'))
					->save();
			}
            return Response::redirect('/bulk');
        }
        else return Response::render();
    }

	public static function edit() {
		$data = [];
		$idx = Request::get('idx');
		if( !empty( $idx ) ){
			$bulk = entity(BULK)->load( $idx );
			
			if( !empty( $bulk ) ){
				$bulk = $bulk->fields;				
				$data['bulk'] = $bulk;
			}
			else{
				$data['message'] = "Invalid Bulk IDX";
			}
		}
		
		$data['template'] = 'bulk.create';
		return Response::render( $data );
	}
	
	public static function delete() {
		$data = [];
		$idx = Request::get('idx');
		if( !empty( $idx ) ){
			$bulk = entity(BULK)->load( $idx );
			
			if( !empty( $bulk ) ){
				$bulk->delete();
				$data['message'] = "Succesfully deleted Bulk IDX [ $idx ]";
			}
			else{
				$data['message'] = "Invalid Bulk IDX";
			}
		}
		
		$data['template'] = 'bulk.index';
		return Response::render( $data );
	}
	
    public static function send() {
        set_time_limit(0);
        $conds = [];
        $cond = null;
        if ( $location = request('location') ) $conds[] = "province='$location'";
        if ( $category = request('category') ){
			//empty category is different from ignoring category value so I added this
			if( $category == 'no_category' ) $conds[] = "category=''";
			else $conds[] = "category='$category'";
		}
        if ( $days = request('days') ) {
            $stamp = time() - $days * 24 * 60 * 60;
            $conds[] = "stamp_last_sent<$stamp";
        }
        if ( $conds ) {
            $cond = implode(' AND ', $conds);
        }
		
		//temp added by benjamin for limit ( automatic stamp_last_sent to avoid getting the same date )...
		if( $limit = request('limit') ){
			if( $page = request('page') ) $page = ( $page - 1 ) * $limit;
			else $page = 0;
			$cond = $cond." ORDER BY stamp_last_sent ASC LIMIT $page, $limit";
		}

        $bulk = entity(BULK)->load(request('idx'));
        $tag = $bulk->get('name');
        $notify_number = $bulk->get('number');
        $numbers = [];
		
        $rows = entity(BULK_DATA)->rows($cond, "idx,number", \PDO::FETCH_KEY_PAIR);
				
		//di( $notify_number );
		//di( $rows );
		//exit;
		
        if ( $rows ) {
            $success = entity(SMS_SUCCESS)->rows("tag='$tag'", 'idx,number', \PDO::FETCH_KEY_PAIR);
            $queue = entity(SMS_QUEUE)->rows("tag='$tag'", 'idx,number', \PDO::FETCH_KEY_PAIR);
			//this will just omit the numbers from blocked number ( and we will not receive any notice that the number in bulk sending is blocked
            $blocked = entity(BULK_BLOCKED)->rows(null, 'idx,number', \PDO::FETCH_KEY_PAIR);
			
            $data = array_diff( $rows, $success, $queue, $blocked );
            if ( $data ) {
                $idxes = array_keys($data);
                $str_idxes = implode(',', $idxes);
                $q = "UPDATE ".BULK_DATA." SET stamp_last_sent=".time()." WHERE idx IN ( $str_idxes );";

                entity()->runExec($q);
                $numbers = array_values($data);
                $data = smsgate::scheduleMessage($numbers, $bulk->get('message'), $tag);
                if ( !empty($data['scheduled']) ) {
                    smsgate::scheduleMessage($notify_number, "Bulk - $tag ($cond) - has been sent (".count($rows).")", $tag . ':notify:' . date('ymdHis'));
                }		
            }
			$blocked_list = array_intersect( $rows, $blocked );
			if( $blocked_list ){
				foreach( $blocked_list as $bl ){
					$item = [];
					$item['number'] = $bl;
					$item['message'] = "Number is blocked";
					$data['error_number'][] = $item;
				}
			}
        }

        $data['template'] = 'bulk.sent';
        $data['numbers'] = &$numbers;
        $data['cond'] = $cond;
        Response::render($data);
    }
	
	public static function block() {
		$data = [];
        if ( submit() ) {		
			$numbers = explode("\n", Request::get('numbers'));
			$reason = Request::get('reason');
			
			if( $numbers ){
				$data = self::block_sms_numbers( $numbers, $reason );				
				$data['template'] = 'bulk.block.sent';
			}
        }
		
		$data['page'] = 'block';
        Response::render( $data );
    }
	
	public static function block_list(){		
		$data = [];
		$data['page'] = "block_list";
		$data['template'] = "bulk.block.list";
		
		Response::render( $data );
	}
	
	//this looks like scheduleMessage... should merge...?
	//atleast this can be in smsgate? ( inserting numbers inside smsgate_blocked )
	public static function block_sms_numbers( $numbers, $reason){
		if( empty( $reason ) ) return [ 'error'=>-6001, 'Reason cannot be empty.'];
		else if( strlen( $reason ) > 256 ) return [ 'error'=>-6002, 'Reason length too long. Should be less than [ 256 ].'];
		
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
		
		$q = "";
		if( !empty( $_numbers ) ){
			foreach( $_numbers as $adjust_number ) {
				$sms = entity(BULK_BLOCKED)->row( "number = '$adjust_number'", 'idx,number', \PDO::FETCH_KEY_PAIR);
				$now = time();
				
				if( empty( $sms ) ){					
					$priority = request('priority', 0);
					//$tag = $tag;
					$q .= "INSERT INTO " . BULK_BLOCKED . " (created, number, reason) VALUES ($now , '$adjust_number', '$reason');";
					$number_info = [];
					$number_info['message'] = "Successfully Blocked: ";
					$number_info['number'] = $adjust_number;
					$data['scheduled'][] = $number_info;					
				}
				else{
					$q .= "UPDATE " . BULK_BLOCKED . " SET reason='$reason',changed='$now' WHERE idx = ".$sms['idx'].";";					
					$error['message'] = "Number already blocked, updating reason to $reason: ";
					$error['number'] = $adjust_number;
					$data['error_number'][] = $error;
				}
				
			}
		}

		if ( $q ) {
            entity()->beginTransaction();
            entity()->exec($q);
            //system_log($q);
            entity()->commit();
        }
		
		return $data;
	}
	
	public static function block_delete() {
         $data = [];

        $idx = Request::get('idx');

		$ent = entity( BULK_BLOCKED )->load( $idx );
		if( !empty( $ent ) ){
			$data['notice']['type'] = "success";
			$data['notice']['message'] = "Successfully deleted message idx [ $idx ]";
			$ent->delete();
		}
		else{
			$data['notice']['type'] = "error";
			$data['notice']['message'] = "idx [ $idx ] does not exist.";
		}
		$data['page'] = 'block_list';
		$data['template'] = "bulk.block.list";
        
        Response::render($data);
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
}
