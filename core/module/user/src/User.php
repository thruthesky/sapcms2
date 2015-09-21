<?php
namespace sap\core\user;
use sap\core\data\Data;
use sap\src\Entity;
define('USER_TABLE', 'user');

/**
 *
 *
 */
class User extends Entity {

    private static $idxLoginUser = 0;

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
            ->add('session_id', 'varchar', 32)
            ->add('password', 'char', 32)
            ->add('domain', 'varchar', 64)
            ->add('name', 'varchar', 32) // first name
            ->add('middle_name', 'varchar', 32)
            ->add('last_name', 'varchar', 32)
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
            ->add('last_access', 'INT UNSIGNED DEFAULT 0')
            ->add('last_login', 'INT UNSIGNED DEFAULT 0')
            ->add('last_login_ip', 'varchar', 32)
            ->add('block', 'INT UNSIGNED DEFAULT 0') // time of blocked until.
            ->add('block_reason', 'varchar', 1024)
            ->add('resign', 'INT UNSIGNED DEFAULT 0') // time of resigned
            ->add('resign_reason', 'varchar', 1024)
            ->unique('id')
            ->unique('session_id')
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


    /**
     *
     * Makes the user of input $id being logged in.
     *
     * @Attention This methods
     *
     *      (1) sets cookie information for login
     *      (2) sets last login stamp
     *      (3) sets last login ip
     *      (4) logs for login activity.
     *
     * @param $id
     *
     *
     * @code
     *      if ( ! login() ) User::login(Request::get('id'));
     * @endcode
     *
     * @return string - returns session_id
     *
     */
    public static function login($id)
    {
        $user = user('id', $id);
        session_set('user-id', $id);
        $session_id = self::getUserSessionID($user);
        session_set('user-session-id', $session_id);
        self::$idxLoginUser = $user->get('idx');
		user()
            ->which($user->get('idx'))
            ->set('session_id', $session_id)
            ->set('last_login', time())
            ->set('last_login_ip', ip())
            ->save();
        user_activity('login');
        return $session_id;
    }

    public static function logout() {
        self::$idxLoginUser = 0;
        session_delete('user-id');
        session_delete('user-session-id');
    }

    /**
     * @param Entity $user
     * @return string
     */
    public static function getUserSessionID(Entity &$user)
    {
        $str = $user->get('idx');
        $str .= ':' . $user->get('id');
        $str .= ':' . $user->get('password');
        return md5($str);
    }

    /**
     * Returns login user Entity
     *
     * @note $idxLoginUser is being used when there is no session information. like below...
     *      - when it is logged by script.
     *      - when the user is being used by session_id
     *
     * @IMPORTANT This method is the one which must be used for all the use of User Identification.
     *
     *
     * @cycle
     *          1. check if $idxLoginUser has value.
     *          2. check if user-id and user-session-id has value.
     *          3. check if request('session_login') has value.
     *
     * @return $this|bool
     *
     * @hook it generates 'user_getCurrent' hook.
     *      if it returns other than 'null', then it uses the returns value of the hook.
     *      so, if define 'user_getCurrent', you can return 'null', 'FALSE', 'User Entity'
     *      if hook does not return anything, this 'getCurrent()' will run its own code.
     *      if hook returns FALSE, user information will not be returned.
     *
     */
    public function getCurrent() {
        $re = hook('user_getCurrent');
        if ( $re !== null ) return $re;
        if ( self::$idxLoginUser ) {
            return $this->load(self::$idxLoginUser);
        }
        $id = session_get('user-id');
        $session_id = session_get('user-session-id');
        if ( $id && $session_id ) {
            if ( empty($id) || empty($session_id) ) return FALSE;
            if ( ! $this->load('id', $id) ) return FALSE;
            if ( $session_id == User::getUserSessionID($this) ) return $this;
        }
        else if ( $session_login = request('session_login') ) {
            return $this->load('session_id', $session_login);
        }
        else return FALSE;
    }


    /**
     *
     * Sets ONLY basic fields of the user.
     *
     *      - It does not set password, domain, ip, etc.
     *      - DOMAIN must be set in other place.
     *
     * @param $options
     */
    public function setBasicFields($options) {			
        if ( isset($options['name']) ) $this->set('name', $options['name']);
        if ( isset($options['middle_name']) ) $this->set('middle_name', $options['middle_name']);
        if ( isset($options['last_name']) ) $this->set('last_name', $options['last_name']);
        if ( isset($options['nickname']) ) $this->set('nickname', $options['nickname']);
        if ( isset($options['mail']) ) $this->set('mail', $options['mail']);
        if ( isset($options['birth_year']) ) $this->set('birth_year', $options['birth_year']);
        if ( isset($options['birth_month']) ) $this->set('birth_month', $options['birth_month']);
        if ( isset($options['birth_day']) ) $this->set('birth_day', $options['birth_day']);
        if ( isset($options['landline']) ) $this->set('landline', $options['landline']);
        if ( isset($options['mobile']) ) $this->set('mobile', $options['mobile']);
        if ( isset($options['address']) ) $this->set('address', $options['address']);
        if ( isset($options['country']) ) $this->set('country', $options['country']);
        if ( isset($options['province']) ) $this->set('province', $options['province']);
        if ( isset($options['city']) ) $this->set('city', $options['city']);
        if ( isset($options['school']) ) $this->set('school', $options['school']);
        if ( isset($options['work']) ) $this->set('work', $options['work']);
    }


    /**
     * Returns User's primary photo Data Entity
     *
     * @return bool|Data
     */
    public function getPrimaryPhoto() {
        $idx = $this->get('idx');
        if ( $idx ) {
            $files = data()->loadBy('user', 'primary_photo', 0, $idx);
            if ( $files ) {
                $file = current($files);
                return $file;
            }
            else return FALSE;
        }
        else return FALSE;
    }

    /**
     * @param int $w
     * @param int $h
     * @return null|string
     */
    public function getPrimaryPhotoUrlThumbnail($w=80, $h=80) {
        $url_primary_photo = null;
        if ( login() ) {
            $file = login()->getPrimaryPhoto();
            if ( $file ) {
                $url_primary_photo = $file->urlThumbnail($w,$h);
            }
        }
        return $url_primary_photo;
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

}