<?php
namespace sap\core\User;
use sap\src\Entity;
define('USER_TABLE', 'user');
class User extends Entity {
    private $fields = [];


    public function __construct() {
        parent::__construct(USER_TABLE);
    }


    public function create($id=null) {
        parent::create();
        if ( $id ) $this->set('id', $id);
        return $this;
    }


    public function createTable()
    {
        parent::createTable()
            ->add('id', 'varchar', 32)
            ->add('password', 'char', 32)
            ->add('domain', 'varchar', 64)
            ->add('name', 'varchar', 32)
            ->add('nickname', 'varchar', 32)
            ->add('mail', 'varchar', 64)
            ->add('birth_year', 'int')
            ->add('birth_month', 'int')
            ->add('birth_day', 'int')
            ->add('landline', 'varchar', 32)
            ->add('mobile', 'varchar', 32)
            ->add('address', 'varchar', 255)
            ->add('country', 'varchar', 255)
            ->add('province', 'varchar', 255)
            ->add('city', 'varchar', 255)
            ->add('school', 'varchar', 128)
            ->add('work', 'varchar', 128)
            ->unique('id')
            ->index('domain')
            ->index('name')
            ->index('nickname')
            ->index('mail')
            ->index('birth_year,birth_month,birth_day');
    }

    /**
     * @param $id
     * @param $password
     * @return int
     *
     *      - TRUE if login is OKay.
     *      - FALSE if error. Use get_error() function to check error.
     *
     * @Attention Use this method to check User ID and Password.
     *
     *      - Do not use Entity()->checkPassword directly since the return value is confusing.
     *
     *
     */
    public static function checkIDPassword($id, $password)
    {
        $user = user()->load('id', $id);
        //print_r(__METHOD__);
        //print_r($user);
        if ( $user ) {
            if ( $user->checkPassword($password) ) return TRUE;
            else {
                error(ERROR_WRONG_PASSWORD);
                return FALSE;
            }
        }
        else {
            error(ERROR_USER_NOT_FOUND_BY_THAT_ID, ['id'=>$id]);
            return FALSE;
        }
    }

    private static function checkUserID($id)
    {
        if ( empty($id) ) return error(ERROR_ID_IS_EMPTY);
        if ( strlen($id) > 32 ) return error(ERROR_ID_TOO_LONG);
        return OK;
    }

    public static function login($id)
    {
        $user = user('id', $id);
        session_set('user-id', $id);
        session_set('user-session-id', self::getUserSessionID($user));
    }
    public static function logout() {
        session_delete('user-id');
        session_delete('user-session-id');
    }

    public static function getUserSessionID(Entity &$user)
    {
        $str = $user->get('idx');
        $str .= ':' . $user->get('id');
        $str .= ':' . $user->get('password');
        $str .= ':' . $user->get('name');
        $str .= ':' . $user->get('email');
        return md5($str);
    }

}