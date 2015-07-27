<?php

if ( Request::install() ) {
    System::runModule();
}
else {
    if ( ! $system->install() ) Response::redirect(Route::create('Install', 'Form'));
}
