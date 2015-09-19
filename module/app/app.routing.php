<?php
use sap\src\Route;
Route::add('/app/front_page', 'app\\App\\frontPage');
Route::add('/app/offline', 'app\\App\\offline');
Route::add('/app/postList/*', 'app\\App\\postList');
Route::add('/app/login', 'app\\App\\login');
Route::add('/app/loginSubmit', 'app\\App\\loginSubmit');
Route::add('/app/logout', 'app\\App\\logout');
Route::add('/app/profile', 'app\\App\\profile');
Route::add('/app/post/submit', 'app\\App\\postSubmit');
Route::add('/app/post/comment/submit', 'app\\App\\postCommentSubmit');
Route::add('/app/upload', 'app\\App\\upload');

