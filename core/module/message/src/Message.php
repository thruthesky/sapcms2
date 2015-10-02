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

    public static function messageCreate() {
		di( User()->load(1) );
		exit;
		Response::render();
    }

    public static function send() {
		message()->set('idx_from',request('idx_from'))
		->set('idx_to',request('to'))
        ->set('title', request('title'))
        ->set('content', request('content'))
		->save();
		
		$data['template'] = 'message.messageCreate';
		//$data['page'] = 'send';
        Response::render($data);
    }


    

}
