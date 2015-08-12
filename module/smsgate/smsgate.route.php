<?php
use sap\src\Route;

Route::add('/smsgate/send', "smsgate\\smsgate\\send");
Route::add('/smsgate/list/queue', "smsgate\\smsgate\\queue");
Route::add('/smsgate/delete', "smsgate\\smsgate\\delete");
Route::add('/smsgate/sender/load', "smsgate\\smsgate\\sender_load_sms_from_queue");
Route::add('/smsgate/sender/result', "smsgate\\smsgate\\sender_record_result");
