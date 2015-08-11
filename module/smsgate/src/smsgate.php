<?php
namespace sap\smsgate;

use sap\src\Response;

class smsgate {
    public static function page() {
        Response::render();
    }

    public static function load_a_message() {

        $row = db_row('sms_extract_numbers');

        Response::json($row);
    }
}

