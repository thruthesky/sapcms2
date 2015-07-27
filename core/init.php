<?php
include 'config.php';
include 'include/Javascript.php';
include 'include/error_reporting.php';
include 'include/System.php';
include 'include/Response.php';
$system = system::load();

if ( ! $system->install() )  Response::redirect('core/install.php');

if ( $system->runOnCommandLineInterface() ) {
    echo "It runs on CLI";
}
else {
    echo "It runs on Web";
}






