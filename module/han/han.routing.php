<?php
use sap\src\Route;

//Route::add('/introduction', 'wooreeedu\\Wooreeedu\\introduction');

Route::add('/introduction/*', 'han\\Han\\introduction');
Route::add('/course/*', 'han\\Han\\course');
Route::add('/junior/*', 'han\\Han\\junior');
Route::add('/camp/*', 'han\\Han\\camp');
Route::add('/gallery/*', 'han\\Han\\gallery');

