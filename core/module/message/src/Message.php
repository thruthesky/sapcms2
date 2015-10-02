<?php
namespace sap\core\message;
use sap\core\user\User;
use sap\core\data\Data;
use sap\src\Entity;
use sap\src\Request;
use sap\src\Response;

class Message extends Entity {

    public function __construct() {
        parent::__construct(MESSAGE_TABLE);
    }
	
	public static function collection( $options = [] ) {
		$data = [];
		$show = request('show');
		$keyword = request('keyword');
		$extra = request('extra');
		$q = '';
		
		if( empty( $show ) ) $show = 'inbox';			
		
		if( $show == 'inbox' ) $q = "idx_to = ".login('idx');
		else if( $show == 'sent' ) $q = "idx_from = ".login('idx');
		
		if( !empty( $keyword ) ) $q .= " AND ( title LIKE '%$keyword%' OR content LIKE '%$keyword%' )";
		if( !empty( $extra ) ) $q .= ' AND checked = 0';	
		
		$q .= " ORDER BY created DESC";
		
		$data['show'] = $show;
		$data['extra'] = $extra;
		$data['keyword'] = $keyword;
		$data['messages'] = message()->rows( $q );
		$data['template'] = 'message.list';
		$data['options'] = $options;
		Response::render($data);
	}	    
	
    public static function messageCreate( $options = [] ) {
		$data['input'] = request();
		$data['options'] = $options;
		$data['template'] = 'message.messageCreate';
		Response::render( $data );
    }

    public static function send() {
		$data = [];
		$user_id_to = request('user_id_to');
		$fid = request('fid');
		
		if( empty( $user_id_to ) ){
			$code = '-20000';
			$message = 'User ID cannot be empty';
		}
		else{
			$user_to = User()->load( 'id', $user_id_to );
			if( !empty( $user_to ) ){
				$idx_to = $user_to->idx;
				//if not error
				$message_entity = message()->set('idx_from',login('idx'))
				->set('idx_to',$idx_to)
				->set('title', request('title'))
				->set('content', request('content'))
				->save();
				
				$code = 0;
				$message = "Succesfully sent the message to [ $user_id_to ]";
				
				if( !empty( $fid ) ) $message_entity->updateFormSubmitFiles();
			}
			else{
				$code = '-20001';
				$message = "Invalid user id [ $user_id_to ]";
			}
		}
		if( $code != 0 ) self::messageCreate( [ 'code'=>$code, 'message'=>$message ] );
		else return Response::redirect('/message?show=sent');
    }	
	
	public static function messageDelete() {
		$idx = request('idx');
		$code = 0;
		$message = '';
		if( !empty( $idx ) ){
			$message = message()->load( $idx );
			if( $message->idx_to != login('idx') ){
				$code = -10002;
				$message = "CYou are not the one who received this message. Message not deleted";
			}
			else if( !empty( $message ) ){
				$message->delete();				
				$message = "Succesfully deleted idx [ $idx ].";
			}
			else{
				$code = -10001;
				$message = "IDX [ $idx ] does no exist.";
			}
		}
		else{
			$code = -10000;
			$message = "IDX cannot be empty.";
		}
		
		self::collection( [ 'code'=>$code, 'message'=>$message ] );
	}
	
	 public static function markAsRead() {		
		$idx = request('idx');
		if( empty( $idx ) ) return null;
		$message = message()->load( $idx );
		
		if( $message->idx_to != login('idx') ) return Response::json(['error'=>'0','message'=>'Not your post, do not mark as read.']);
		
		if( !empty( $message ) ) $message->set( 'checked', time() )->save();
		else return Response::json(['error'=>'-2001','message'=>'Invalid message IDX!']);
		
		return Response::json(['error'=>'0','message'=>'Success']);
	 }
	 
	 
	 
	 
	 
	 
	 //copied from postdata.php
	 public function updateFormSubmitFiles() {
        $fid = request('fid');		
        if ( empty($fid) ) return;

        sys()->log(__METHOD__);
        sys()->log("fid: $fid");

        $idxes = explode(',', $fid);
        if ( empty($idxes) ) return;

        foreach( $idxes as $idx ) {
            if ( is_numeric($idx) ) {
                $file = data($idx);
                if ( $file ) {
                    $file
                        ->set('module', 'message')
                        ->set('type', 0)
                        ->set('idx_target', $this->get('idx'))
                        ->set('finish', 1)
                        ->save();
                }
            }
        }
    }
}
