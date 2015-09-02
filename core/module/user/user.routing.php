<?php
use sap\src\Route;

Route::add('/user', 'user\\UserController\\profile');
Route::add('/user/register', 'user\\UserController\\register');

Route::add('/user/resign', 'user\\UserController\\resign');
Route::add('/user/resign/submit', 'user\\UserController\\resignSubmit');


Route::add('/admin/user/edit', 'user\\UserController\\adminUserEdit');
Route::add('/admin/user/block', 'user\\UserController\\adminUserBlock');


Route::add('/user/profile', 'user\\UserController\\profile');
Route::add('/user/login', 'user\\UserController\\login');
Route::add('/user/logout', 'user\\UserController\\logout');

Route::add('/user/setting', 'user\\UserController\\setting');


Route::add('/admin/user', 'user\\UserController\\userList');


route('/user/hello/*', 'user\\UserController\\hello');
