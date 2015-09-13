<?php

use sap\src\Route;

Route::add('/mobilepost/list/*', 'mobilepost\\MobilePost\\postList');
Route::add('/mobilepost/create/*', 'mobilepost\\MobilePost\\postCreate');
Route::add('/mobilepost/create/submit', 'mobilepost\\MobilePost\\postCreateSubmit');
Route::add('/mobilepost/edit/*', 'mobilepost\\MobilePost\\postEdit');
Route::add('/mobilepost/edit/submit', 'mobilepost\\MobilePost\\postEditSubmit');
Route::add('/mobilepost/comment/submit', 'mobilepost\\MobilePost\\postCommentSubmit');
Route::add('/mobilepost/comment/edit', 'mobilepost\\MobilePost\\postCommentEdit');
Route::add('/mobilepost/comment/edit/submit', 'mobilepost\\MobilePost\\postCommentEditSubmit');
Route::add('/mobilepost/view', 'mobilepost\\MobilePost\\postView');
Route::add('/mobilepost/search', 'mobilepost\\MobilePost\\searchPostData');

