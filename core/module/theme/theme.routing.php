<?php
use sap\src\Route;

Route::add('/admin/theme/config', 'theme\\ThemeController\\config');
Route::add('/admin/theme/config/submit', 'theme\\ThemeController\\configSubmit');
Route::add('/admin/theme/config/delete/*', 'theme\\ThemeController\\configDelete');
