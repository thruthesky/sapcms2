<?php
namespace sap\core\user;
use sap\src\Request;
use sap\src\Response;

class UserController
{
    public static function profile()
    {
        if ( submit() ) {
            $options['id'] = login('id');
            $options['name'] = request('name');
            $options['mail'] = request('mail');
            self::updateUser($options);
        }
        Response::render(['template' => 'user-profile']);
    }


    public static function register()
    {
        if ( submit() ) return self::registerFormSubmit();

        return self::userRegisterTemplate();
    }


    public static function createUser($options) {

        $user = user();
        $user ->create($options['id']);
        if ( isset($options['password']) ) $user->setPassword($options['password']);

        if ( isset($options['domain']) ) $user->set('domain', $options['domain']);
        else $user->set('domain', domain());



        if ( isset($options['name']) ) $user->set('name', $options['name']);
        if ( isset($options['middle_name']) ) $user->set('middle_name', $options['middle_name']);
        if ( isset($options['last_name']) ) $user->set('last_name', $options['last_name']);
        if ( isset($options['nickname']) ) $user->set('nickname', $options['nickname']);
        if ( isset($options['mail']) ) $user->set('mail', $options['mail']);
        if ( isset($options['birth_year']) ) $user->set('birth_year', $options['birth_year']);
        if ( isset($options['birth_month']) ) $user->set('birth_month', $options['birth_month']);
        if ( isset($options['birth_day']) ) $user->set('birth_day', $options['birth_day']);
        if ( isset($options['mobile']) ) $user->set('mobile', $options['mobile']);

        $user->save();
        return $user;


    }

    /**
     *
     * @deperecated Do not use this function. Use createUser method.
     * @return bool|string
     */
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
			else {
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


    /**
     *
     * @Attention Use this method only for registering. You cannot use this for updating.
     *
     * @return int|mixed
     */
    private static function validateRegisterFrom()
    {
        if ( login('idx') ) {
            return error(-50809, "You already logged in");
        }


        $id = request('id');
        $pw = request('password');
        if ( empty( $id ) ) return error(-50801, "Please input ID");
        if ( empty( $pw ) ) return error(-50802, "Please input password");

        /**
         * @TODO get system option of which form field are required.
         */
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



    private static function registerFormSubmit()
    {
        if ( self::validateRegisterFrom() ) return self::userRegisterTemplate();

        $options['id'] = request('id');
        $options['password'] = request('password');
        $options['name'] = request('name');
        $options['mail'] = request('mail');

        $user = self::createUser($options);
        if ( empty($user) ) return self::userRegisterTemplate();

        return Response::redirect(config()->getUrlSite());

    }

    private static function userRegisterTemplate()
    {

        $data = [];
        $data['input'] = Request::get();
        $data['template'] = 'user.register';

        return Response::render($data);
    }

    private static function updateUser($options)
    {

        $user = user($options['id']);
        unset($options['id']);
        if ( isset($options['password']) ) {
            $user->setPassword($options['password']);
            unset($options['password']);
        }

        if ( $options ) {
            foreach( $options as $field => $value ) {
                $user->set($field, $value);
            }
        }
        $user->save();
        return $user;
    }


}
