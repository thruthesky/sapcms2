<?php
use sap\src\Route;

Route::add('/smsgate/send', "smsgate\\smsgate\\send");
Route::add('/smsgate/list/queue', "smsgate\\smsgate\\queue");
Route::add('/smsgate/delete', "smsgate\\smsgate\\delete");
Route::add('/smsgate/load-a-message', "smsgate\\smsgate\\load_a_message");
