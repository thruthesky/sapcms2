<?php
namespace sap\src;
class Date {
    static $months =	[
        "1"=>"January",
        "2"=>"February",
        "3"=>"March",
        "4"=>"April",
        "5"=>"May",
        "6"=>"June",
        "7"=>"July",
        "8"=>"August",
        "9"=>"September",
        "10"=>"October",
        "11"=>"November",
        "12"=>"December",
    ];

    public static function months() {
        return self::$months;
    }
    public static function years() {
        $years = [];
        for( $i = 1940; $i <= date( "Y",time() ); $i++ ){
            $years[$i] = $i;
        }
        return $years;
    }
    public static function days() {
        $days = [];
        for( $i = 1; $i <= 31; $i++ ){
            $days[$i] = $i;
        }
        return $days;
    }
}