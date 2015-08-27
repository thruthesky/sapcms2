<?php
namespace sap\core\user;
use sap\src\Request;
use sap\src\Response;

class UserController
{
    public static function profile()
    {
        if (self::userFormSubmit()) {
        }
        Response::renderSystemLayout(['template' => 'user-profile']);
    }


    public static function register()
    {
        if ( $submit_response = self::userFormSubmit() ) {
			if( $submit_response == 'admin-edit' ) return Response::redirect('/admin/user');
            return Response::redirect(config()->getUrlSite());
        }
		
		$data = [];
		$data['input'] = Request::get();
		if( !empty( $data['input']['idx'] ) ){
			//check if admin
			$idx = $data['input']['idx'];
			$user = user( $idx );
			$data['user'] = $user;			
		}

		$data['template'] = 'user-register';
		
        return Response::render($data);
    }

    public static function userFormSubmit() {
		if ( submit()) {
			if ( self::validateRegisterFrom() == OK ) {
				$idx = Request::get('idx');
				if( $idx ){
					//if admin...
					$user = user( $idx );
					$is_admin_edit = 'admin-edit';//temp just for redirect
				}
				else{
					if ( login() ) {
						$user = login();
					}
					else {
						$user = user();
						$user ->create(Request::get('id'))
						->setPassword(Request::get('password'));
					}
				}
				
				if( $user ){					
					$user->set('name', Request::get('name'))
						->set('mail', Request::get('mail'));			
					$user->save();
				}
				else{
					//return invalid user ID
				}
				
				if ( ! login() ) User::login(Request::get('id'));
				
				if( !empty( $is_admin_edit ) ) return $is_admin_edit;
                return TRUE;
			}
			else{
				$error = self::validateRegisterFrom();
				//return $error;
			}
		}

        return FALSE;
    }

    public static function login()
    {
        if (submit()) {

		$re = User::checkIDPassword(Request::get('id'), Request::get('password'));
            if ( $re ) {
                User::login(Request::get('id'));
                return Response::redirect(ROUTE_ROOT);
            }
            else {

            }
        }
        return Response::render(['template' => 'user-login']);
    }


    public static function logout()
    {
        if ( login() ) my()->logout();

        return Response::redirect(config()->getUrlSite());
    }

    private static function validateRegisterFrom()
    {
        if ( login('idx') ) {

        }
        else {
		$id = request('id');
		$pw = request('password');
            if ( empty( $id ) ) return error(-50800, "Please input ID");
            if ( empty( $pw ) ) return error(-50800, "Please input password");
        }

	$name = request('name');
	$mail = request('mail');
        if ( empty($name) ) return error(-50800, "Please input name");
        if ( empty($mail) ) return error(-50800, "Please input email");

        return OK;
    }

    public static function userList() {
        return Response::renderSystemLayout(['template'=>'admin.user-list']);
    }



    public static function setting()
    {
        if (submit()) {
            session_set(USER_TIMEZONE_1, request(USER_TIMEZONE_1));
            session_set('language', request('language'));
            return Response::redirect('/user/setting');
        }
        return Response::render(['template' => 'user.setting']);
    }


}
