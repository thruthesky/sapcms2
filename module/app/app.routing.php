<?php
use sap\src\Route;
Route::add('/app/front_page', 'app\\App\\frontPage');
Route::add('/app/offline', 'app\\App\\offline');
Route::add('/app/postList/*', 'app\\App\\postList');
Route::add('/app/postListMore/*', 'app\\App\\postListMore');
Route::add('/app/login', 'app\\App\\login');
Route::add('/app/loginSubmit', 'app\\App\\loginSubmit');
Route::add('/app/logout', 'app\\App\\logout');
Route::add('/app/profile', 'app\\App\\profile');
Route::add('/app/register', 'app\\App\\register');
Route::add('/app/registerSubmit', 'app\\App\\registerSubmit');
Route::add('/app/profileUpdateSubmit', 'app\\App\\profileUpdateSubmit');
Route::add('/app/post/submit', 'app\\App\\postSubmit');
Route::add('/app/post/comment/submit', 'app\\App\\postCommentSubmit');
Route::add('/app/upload', 'app\\App\\upload');
Route::add('/app/delete', 'app\\App\\postDelete');

Route::add('/app/getPostEditForm', 'app\\App\\getPostEditForm');
Route::add('/app/getPostCommentEditForm', 'app\\App\\getPostCommentEditForm');
Route::add('/app/post/edit/submit', 'app\\App\\PostEditSubmit');
Route::add('/app/post/edit/comment/submit', 'app\\App\\PostEditCommentSubmit');

Route::add('/app/post/getPostFiles', 'app\\App\\getPostFiles');

Route::add('/app/view_post/*', 'app\\App\\viewPost');

Route::add('/app/loginCheck', 'app\\App\\loginCheck');

