<?php
use sap\src\Route;

Route::add('/admin/category/setting', 'category\\CategoryController\\setting');
Route::add('/admin/category/setting/submit', 'category\\CategoryController\\settingSubmit');
Route::add('/admin/category/setting/delete', 'category\\CategoryController\\categoryDelete');
Route::add('/admin/category/setting/deleteSubmit', 'category\\CategoryController\\categoryDeleteSubmit');

