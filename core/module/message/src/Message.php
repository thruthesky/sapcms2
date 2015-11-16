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
		$user_idx = login('idx');
		
		if( empty( $user_idx ) ){
			$data = ['template'=>'message.error.page','options'=>['code'=>'-1001','message'=>'You are not Logged in']];
		}
		else{
			$data = self::getCollection( $options );
		}
		Response::render($data);
	}	    
	
	public static function getCollection( $options = [] ){
		$data = [];

		$show = request('show');
		$keyword = request('keyword');
		$extra = request('extra');
		$page = request('page');
		$limit = request('limit');
		$default_url = request('default_url');
		$q = '';
				
		
		if( empty( $page ) ) $page = 1;
		if( empty( $limit ) ) $limit = 10;
		if( empty( $paging ) ) $paging = 5;	
		if( empty($default_url) ) $default_url = "/message?show=$show&extra=$extra";
		if( empty( $show ) ) $show = 'inbox';

		if( $show == 'inbox' ) $q = "idx_to = ".login('idx');
		else if( $show == 'sent' ) $q = "idx_from = ".login('idx');		
		if( !empty( $keyword ) ) $q .= " AND ( title LIKE '%$keyword%' OR content LIKE '%$keyword%' )";
		if( !empty( $extra ) ) $q .= ' AND checked = 0';				
		
		$q .= " ORDER BY created DESC";
		
		
		$total_messages = message()->count( $q );
		
		$q .= " LIMIT ".( $page * $limit - $limit ).", $limit";
		
		$max_pages = ceil( $total_messages/ $limit );
		
		$data['page_start'] = floor( $page / $paging ) * $paging + 1;
		$data['page_end'] = ceil( $page / $paging ) * $paging;
		if( $data['page_end'] > $max_pages ) $data['page_end'] = $max_pages;
		$data['max_pages'] = $max_pages;
		$data['paging'] = $paging;
		$data['show'] = $show;
		$data['extra'] = $extra;
		$data['keyword'] = $keyword;
		$data['default_url'] = $default_url;			
		if( $limit != 10 ) $data['default_url'] .= "&limit=$limit";
		$data['total_messages'] = $total_messages;
		$data['messages'] = message()->rows( $q );
		$data['template'] = 'message.list';
		$data['options'] = $options;
		
		return $data;
	}
	
    public static function messageCreate( $options = [] ) {
		$data['input'] = request();
		$data['options'] = $options;
		$data['template'] = 'message.messageCreate';
		Response::render( $data );
    }

    public static function send() {
		$data = self::messageSubmit();
		if( $data['code'] != 0 ) self::messageCreate( $data );
		else return Response::redirect('/message?show=sent');
    }	
	
	public static function messageSubmit(){
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
				$idx_from = login('idx');
				
				$title = request('title');
				if( empty( $title ) ) $title = "No Title";
				$content = request('content');
				if( empty( $content ) ) $content = "No Content";
				
				if( empty( $idx_from ) ) $idx_from = 0;
				$message_entity = message()->set('idx_from',$idx_from)
				->set('idx_to',$idx_to)
				->set('title', $title)
				->set('content', $content)
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
		
		return [ 'code'=>$code, 'message'=>$message ];
	}
	
	public static function messageDelete() {
		$idx_request = request('idx');				
		$data = self::deleteConfirm( $idx_request );		
		self::collection( $data );
	}
	
	public static function deleteConfirm( $idx_request ){
		if( empty( $idx_request ) ) return ['code'=>'-2005','message'=>'You must select atleast one ( 1 ) message to delete!'];
	
		$code = 0;
		$message = '';
		$idxs = explode( "," , $idx_request );
		foreach( $idxs as $idx ){
			if( empty( $idx ) ) continue;

			$message = message()->load( $idx );
			if( empty( $message ) ){
				$code = -10001;
				$message = "IDX [ $idx ] does not exist.";
				return [ 'code'=>$code, 'message'=>$message ];
			}
			else if( $message->idx_to != login('idx') ){
				$code = -10002;
				$message = "You are not the one who received this message. Message not deleted";
				return [ 'code'=>$code, 'message'=>$message ];
			}
			else if( !empty( $message ) ){
				$message->delete();				
				$message = "Succesfully deleted idx [ $idx ].";				
			}
		}
		return [ 'code'=>$code, 'message'=>$message ];		
	}
	
	 public static function markAsRead() {		
		$idx_request = request('idx');
		if( empty( $idx_request ) ) return Response::json(['error'=>'-2005','message'=>'You must select atleast one ( 1 ) message to mark as read!']);
		
		$idxs = explode( "," , $idx_request );
		foreach( $idxs as $idx ){
		if( empty( $idx ) ) continue;
		if( empty( $idx ) ) return null;
			$message = message()->load( $idx );
			
			if( $message->idx_to != login('idx') ) return Response::json(['error'=>'0','message'=>'Not your post, do not mark as read.']);
			
			if( !empty( $message ) ) $message->set( 'checked', time() )->save();
			else return Response::json(['error'=>'-2001','message'=>'Invalid message IDX!']);
		}
		return Response::json(['error'=>'0','message'=>'Success','action'=>'markAsRead']);
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
