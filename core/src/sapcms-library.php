<?php
function module_script()
{
    return System::get()
        ->module()
        ->script();
}

function theme_script($filename=null)
{
    global $theme;
    if ( empty($filename) ) $filename = Request::getRoute();
    $path = "theme/$theme/$filename.html.php";
    if ( file_exists($path) ) return $path;
    $module = Request::get('module');
    $path = null;
    if ( System::isCoreModule($module) ) $path = 'core/';
    $path .= "module/$module/template/$filename.html.php";
    return $path;
}

function theme_layout()
{
    global $theme;
    return "theme/$theme/layout.html.php";
}

