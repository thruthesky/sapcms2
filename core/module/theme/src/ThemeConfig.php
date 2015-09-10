<?php
namespace sap\core\theme;
use sap\src\Meta;



class ThemeConfig extends Meta
{
    public function __construct() {
        parent::__construct(THEME_CONFIG);
    }
}
