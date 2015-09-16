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

    //added by benjamin
    public static function adminUserBlock()
    {
        if ( submit() ) return self::adminUserBlockSubmit();
        self::adminUserBlockTemplate();
    }


    /**
     *
     * Creates a user account.
     *
     * @note it does not depends on the input array. Not on the Form Submit.
     * @note if you need to make the user logged in, use self::login() in other place.
     *
     * @param $options
     * @return $this|bool|User
     */
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
     * @Attention This depends on Form submit. Use User::login() to make the user login.
     * @return int|mixed|null
     */
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

        $id = request('id');
        if ( user_exists($id) ) {
            error(-20102, "User ID is in use. Please choose another.");
            return self::userRegisterTemplate();
        }

        $options['id'] = $id;
        $options['password'] = request('password');
        $options['name'] = request('name');
        $options['mail'] = request('mail');

        $user = self::createUser($options);
        if ( empty($user) ) return self::userRegisterTemplate();

        User::login($user->get('id'));

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

    //added by benjamin
    private static function adminUserBlockSubmit() {
        $input = request();
        if( !empty( $input['idx'] ) ){
            //if( empty( $input['block'] ) )  error(-70123, "Please put the date of when the user will be unblocked.");
            $user = user( $input['idx'] );

            if( !empty( $input['block'] ) ) $user->set( 'block', strtotime( $input['block'] ) );
            else error(-70101, "Please put the date of when the user will be unblocked. Block detail was not updated");
            if( !empty( $input['block_reason'] ) ) $user->set( 'block_reason', $input['block_reason'] );
            else error(-70102, "No block reason was added. Block Reason detail was not Updated");

            $user->save();
        }

        self::adminUserBlockTemplate();
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

    private static function adminUserBlockTemplate() {

        $data = [];
        $data['input'] = Request::get();
        $data['template'] = 'admin.user.block';

        //added by benjamin
        $idx = request('idx');
        if( $idx ){
            $user = user( $idx )->get();
            if( empty( $user ) )  error(-50200, "User Does not exist.");
            else $data['user'] = $user;
        }
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
        if( !empty( $options['id'] ) ) unset($options['id']);
        if ( isset($options['password']) ) {
            $login->setPassword($options['password']);
            unset($options['password']);
        }

        // @TODO list the fields.
        if ( $options ) {
            $login->setBasicFields( $options );
        }
        $login->save();
        user_activity('updateUser');
        return $login;
    }


    public static function resign() {
        return Response::render(['template'=>'user.resign']);
    }
    public static function resignSubmit() {
        login()
            ->setPassword(md5(time()))
            ->set('name', '')
            ->set('middle_name', '')
            ->set('last_name', '')
            ->set('nickname', '')
            ->set('mail', '')
            ->set('birth_year', 0)
            ->set('birth_month', 0)
            ->set('birth_day', 0)
            ->set('landline', '')
            ->set('mobile', '')
            ->set('address', '')
            ->set('country', '')
            ->set('province', '')
            ->set('city', '')
            ->set('school', '')
            ->set('work', '')
            ->set('resign', time())
            ->set('resign_reason', request('resign_reason'))
            ->save();
        return Response::redirect(sysconfig(URL_SITE));
    }

}
