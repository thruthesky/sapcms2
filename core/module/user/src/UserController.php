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
        if (self::userFormSubmit()) {
            return Response::redirect(config()->getUrlSite());
        }
        return Response::render(['template' => 'user-register']);
    }

    public static function userFormSubmit() {
        if (submit()) {
            if ( self::validateRegisterFrom() == OK ) {
                if ( login() ) {
                    $user = login();
                }
                else {
                    $user = user();
                    $user ->create(Request::get('id'))
                        ->setPassword(Request::get('password'));
                }
                $user->set('name', Request::get('name'))
                    ->set('mail', Request::get('mail'))
                    ->save();
                if ( ! login() ) User::login(Request::get('id'));
                return TRUE;
            }
        }
        return FALSE;
    }

    public static function login()
    {
        if (submit()) {
            if (User::checkIDPassword(Request::get('id'), Request::get('password'))) {
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
            if ( empty(request('id') ) ) return error(-50800, "Please input ID");
            if ( empty(request('password') ) ) return error(-50800, "Please input password");
        }

        if ( empty(request('name') ) ) return error(-50800, "Please input name");
        if ( empty(request('mail') ) ) return error(-50800, "Please input email");

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
