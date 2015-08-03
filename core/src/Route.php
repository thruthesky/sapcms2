<?php
namespace sap\src;
class Route {

    private static $router = null;
    private $request_uri = null;
    private $segment = null;
    public $module = null;
    public $class = null;
    public $method = null;
    private static $routes = [];

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
     * @param $route
     * @code
     *  Route::set("/A/B/C?ABC=DEF");
     * @endcode
     */
    public static function set($route) {
        $_SERVER['REQUEST_URI'] = "$route";
        parse_str($_SERVER['REQUEST_URI'], $_GET);
        Request::reset();
        Route::load()->reset();
    }


    public static function add($route, $controller) {
        self::$routes[$route] = $controller;
    }

    public static function match($route) {
        return isset(self::$routes[$route]) ? self::$routes[$route] : null;
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
        $route = Request::get( HTTP_VAR_ROUTE );
        if ( empty($route) ) {
            $arr = explode('?', $_SERVER['REQUEST_URI'], 2);
            $route = $arr[0];
        }
        if ( $route ) {
            $this->request_uri = $route;
            if ( $match = self::match( $this->request_uri ) ) {
                $this->segment = explode('\\', $match);
            }
            else {
                $this->request_uri = trim($this->request_uri, '/');
                $this->segment = explode('/', $this->request_uri);
            }
            $this->module = ! empty( $this->segment[0] ) ? $this->segment[0] : DEFAULT_MODULE;
            $this->class = isset( $this->segment[1] ) ? $this->segment[1] : $this->module;
            $this->method = isset( $this->segment[2] ) ? $this->segment[2] : DEFAULT_CONTROLLER;
        }
        return $this;

        /*


        if ( $route = Request::get( HTTP_VAR_ROUTE ) ) {
            $arr = explode('/', $route, 4);
            array_shift($arr);
            $this->module = isset($arr[0]) ? $arr[0] : DEFAULT_MODULE;
            $this->class = isset($arr[1]) ? $arr[1] : $this->module;
            $this->method = isset($arr[2]) ? $arr[2] : DEFAULT_CONTROLLER;
        }
        else {
            $arr = explode('?', $_SERVER['REQUEST_URI'], 2);
            $this->request_uri = $arr[0];
            $this->request_uri = trim($this->request_uri, '/');
            $this->segment = explode('/', $this->request_uri);
            $this->module = ! empty( $this->segment[0] ) ? $this->segment[0] : DEFAULT_MODULE;
            $this->class = isset( $this->segment[1] ) ? $this->segment[1] : $this->module;
            $this->method = isset( $this->segment[2] ) ? $this->segment[2] : DEFAULT_CONTROLLER;
        }
        return $this;
        */
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
    public static function create($module, $class=null, $method='page') {
        if ( $class ) {
            return '?' . HTTP_VAR_ROUTE . "=/$module/$class/$method";
        }
        else {
            return '?' . HTTP_VAR_ROUTE . "=/$module";
        }
    }

    public static function run($route)
    {
        return Module::run($route);
    }


}

