<?php
use sap\src\Route;

//Route::add('/introduction', 'wooreeedu\\Wooreeedu\\introduction');

Route::add('/introduction/*', 'englishworld\\Englishworld\\introduction');
Route::add('/course/*', 'englishworld\\Englishworld\\course');
Route::add('/junior/*', 'englishworld\\Englishworld\\junior');
Route::add('/camp/*', 'englishworld\\Englishworld\\camp');
Route::add('/gallery/*', 'englishworld\\Englishworld\\gallery');

