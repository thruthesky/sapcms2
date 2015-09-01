<?php
namespace sap\core\user;
use sap\src\Request;
use sap\src\Response;

class UserController
{
    public static function profile()
    {
        if ( submit() ) {
            $options = request();
			if( empty( $options['password'] ) ) unset( $options['password'] );
            self::updateUser($options);
        }
        Response::render(['template' => 'user.profile']);
    }

    public static function hello() {

    }

    public static function register()
    {
        if ( submit() ) return self::registerFormSubmit();

        return self::userRegisterTemplate();
    }
	
	//added by benjamin
    public static function adminUserEdit()
    {					
        if ( submit() ) return self::adminUserEditSubmit();
        return self::adminUserEditTemplate();
    }


    public static function createUser($options) {

        $user = user();
        $user ->create($options['id']);
        if ( isset($options['password']) ) $user->setPassword($options['password']);
        if ( isset($options['domain']) ) $user->set('domain', $options['domain']);
        else $user->set('domain', domain());
        $user->setBasicFields($options);
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
	
	//added by benjamin
	private static function adminUserEditSubmit() {
        $user = user( request('idx') );

        if ( $password = request('password') ) $user->setPassword($password);
        if ( $domain = request('domain') ) $user->set('domain', $domain);
        $user->setBasicFields(request());
        $user->save();
		return Response::redirect( "/admin/user/edit?idx=" . request('idx') );
	}

    private static function userRegisterTemplate()
    {

        $data = [];
        $data['input'] = Request::get();
        $data['template'] = 'user.register';
		
		//added by benjamin
		$idx = request('idx');
		if( $idx ) $data['user'] = user( $idx );

        return Response::render($data);
    }

    private static function adminUserEditTemplate() {

        $data = [];
        $data['input'] = Request::get();
        $data['template'] = 'admin.user.edit';

        //added by benjamin
        $idx = request('idx');
        if( $idx ) $data['user'] = user( $idx )->get();
        else {
            error(-50123, "User idx is not provided.");
        }	

        return Response::renderSystemLayout($data);
    }


    /**
     *
     * @Attention Do not put options directly from FORM submit. Form could have invalid or un-wanted data.
     *
     * @Attention This method must only be used to update self information.
     *
     *
     *
     *
     * @param $options
     * @return $this|bool|User
     *
     */
    private static function updateUser($options)
    {
        $login = login();
        unset($options['id']);
        if ( isset($options['password']) ) {
            $login->setPassword($options['password']);
            unset($options['password']);
        }

        // @TODO list the fields.
        if ( $options ) {
            foreach( $options as $field => $value ) {
                $login->set($field, $value);
            }
        }
        $login->save();
        entity(USER_ACTIVITY_TABLE)
            ->set('idx_user', login('idx'))
            ->set('action', 'updateUser')
            ->save();
        return $login;
    }


    public static function resign() {
        return Response::render(['template'=>'user.resign']);
    }
    public static function resignSubmit() {
        login()
            ->setPassword(md5(time()))
            ->set('name', '')
            ->set('mail', '')
            ->set('last_name', '')
            ->set('resign', time())
            ->set('resign_reason', request('resign_reason'))
            ->save();
        return Response::redirect(sysconfig(URL_SITE));
    }

}
