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
        if ( $category = request('category') ) $conds[] = "category='$category'";
        if ( $days = request('days') ) {
            $stamp = time() - $days * 24 * 60 * 60;
            $conds[] = "stamp_last_sent<$stamp";
        }
        if ( $conds ) {
            $cond = implode(' AND ', $conds);
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
            $data = array_diff($rows, $success, $queue);
            if ( $data ) {
                $idxes = array_keys($data);
                $str_idxes = implode(',', $idxes);
                $q = "UPDATE ".BULK_DATA." SET stamp_last_sent=".time()." WHERE idx IN ( $str_idxes );";
                entity()->runExec($q);
                $numbers = array_values($data);
                $data = smsgate::scheduleMessage($numbers, $bulk->get('message'), $tag);
                if ( empty($data['scheduled']) ) {
                    smsgate::scheduleMessage($notify_number, "Bulk - $tag ($cond) - has been sent (".count($rows).")", $tag . ':notify:' . date('ymdHi'));
                }
            }
        }

        $data['template'] = 'bulk.sent';
        $data['numbers'] = &$numbers;
        $data['cond'] = $cond;
        Response::render($data);
    }
}
