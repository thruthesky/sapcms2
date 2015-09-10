<?php
use sap\src\Route;

Route::add('/admin/category/setting', 'category\\CategoryController\\setting');
Route::add('/admin/category/setting/submit', 'category\\CategoryController\\settingSubmit');

