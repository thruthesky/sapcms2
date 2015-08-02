<?php
namespace sap\src;
class Route {

    private static $router = null;
    private $request_uri = null;
    private $segment = null;
    public $module = null;
    public $class = null;
    public $method = null;

    public function __construct() {
    }


    public static function load() {
        if ( self::$router ) return self::$router;
        $route = new Route();
        $route->reset();
        self::$router = $route;
        return self::$router;
    }


    /**
     *
     * This method resets with $_SERVER['REQUEST_URI']
     *
     * @ATTENTION Use this function if every $_SERVER['REQUEST_URI'] has changed.
     *
     * @return $this
     *
     * @code
     *
    $_SERVER['REQUEST_URI'] = "/module/class/method?a=b&c=d";
    $route = Route::load();
    $_SERVER['REQUEST_URI'] = "/System/Install/check?a=b&c=d"; // To apply new request uri.
    $route = Route::load()->reset();
     * @endcode
     */
    public function reset()
    {
        if ( $route = Request::get( HTTP_VAR_ROUTE ) ) {
            $arr = explode('.', $route, 3);
            $this->module = isset($arr[0]) ? $arr[0] : DEFAULT_MODULE;
            $this->class = isset($arr[1]) ? $arr[1] : DEFAULT_CLASS;
            $this->method = isset($arr[2]) ? $arr[2] : DEFAULT_CONTROLLER;
        }
        else {

            $arr = explode('?', $_SERVER['REQUEST_URI'], 2);
            $this->request_uri = $arr[0];
            $this->request_uri = trim($this->request_uri, '/');
            $this->segment = explode('/', $this->request_uri);
            $this->module = ! empty( $this->segment[0] ) ? $this->segment[0] : DEFAULT_MODULE;
            $this->class = isset( $this->segment[1] ) ? $this->segment[1] : DEFAULT_CLASS;
            $this->method = isset( $this->segment[2] ) ? $this->segment[2] : DEFAULT_CONTROLLER;
        }
        return $this;
    }




    /**
     * @param $module
     * @param null $class
     * @param string $method
     * @return string
     *
     * @code
     * core\Response::redirect(core\Route::create("Install.Form.Input"));
     * sap\core\Response::redirect(sap\core\Route::create('Install', 'Form', 'Input'));
     * @code
     */
    public static function create($module, $class=null, $method='defaultController') {
        if ( $class ) {
            return '?' . HTTP_VAR_ROUTE . "=$module.$class.$method";
        }
        else {
            return '?' . HTTP_VAR_ROUTE . '=' . $module;
        }
    }


}

