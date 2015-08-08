<?php
use sap\src\Route;

Route::add('/user', 'User\\UserController\\profile');
Route::add('/user/register', 'User\\UserController\\register');
Route::add('/user/login', 'User\\UserController\\login');
Route::add('/user/logout', 'User\\UserController\\logout');
