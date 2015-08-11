<?php
namespace sap\core\System;
use sap\core\Config\Config;
use sap\core\Install\Install;
use sap\core\User\User;
use sap\src\CommandLineInterface;
use sap\src\Database;
use sap\src\File;
use sap\src\Module;
use sap\src\Request;
use sap\src\Response;
use sap\src\Route;

/**
 *
 *
 *
 */
class SystemController {
    public static function moduleNotEnabled() {
        $module = route()->module;
        return Response::html("Module [ $module ] is not enabled");
    }
}
