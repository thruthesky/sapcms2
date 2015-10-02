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
	
	public static function collection() {
		$data = [];
	
		$data['messages'] = message()->rows("idx_to = ".login('idx'));
		$data['template'] = 'message.list';
		Response::render($data);
	}
	
    public static function messageCreate() {
		Response::render();
    }

    public static function send() {
		$data = [];
	
		$user_to = User()->load( 'id',request('user_id_to') );
		if( !empty( $user_to ) ) $idx_to = $user_to->idx;
		else{
			//error
		}
		//if not error
		message()->set('idx_from',request('idx_from'))
		->set('idx_to',$idx_to)
        ->set('title', request('title'))
        ->set('content', request('content'))
		->save();
		
		$data['template'] = 'message.messageCreate';
		//$data['page'] = 'send';
        Response::render($data);
    }	
}
