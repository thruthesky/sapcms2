<?php
namespace sap\core\user;
use sap\src\Request;
use sap\src\Response;

class UserController
{
    public static function profile()
    {
        Response::renderSystemLayout(['template' => 'user-profile']);
    }


    public static function register()
    {
        if (submit()) {
            if ( self::validateRegisterFrom() ) {
                user()
                    ->create(Request::get('id'))
                    ->setPassword(Request::get('password'))
                    ->set('name', Request::get('name'))
                    ->save();
                User::login(Request::get('id'));
                return Response::redirect(config()->getUrlSite());
            }
        }
        return Response::render(['template' => 'user-register']);
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
        return true;
    }


    public static function userList() {
        return Response::renderSystemLayout(['template'=>'admin.user-list']);
    }

}
