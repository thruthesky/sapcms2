<?php
use sap\src\Route;

Route::add('/user', 'user\\UserController\\profile');
Route::add('/user/register', 'user\\UserController\\register');
Route::add('/user/login', 'user\\UserController\\login');
Route::add('/user/logout', 'user\\UserController\\logout');

Route::add('/admin/user', 'user\\UserController\\userList');

