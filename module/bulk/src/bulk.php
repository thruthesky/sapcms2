<?php
namespace sap\bulk;


use sap\src\Response;

class bulk {
    public static function index() {
        return Response::render();
    }
    public static function create() {
        if ( submit() ) {
            di( entity(BULK_DATA)->count() );
            //return Response::redirect('/bulk/list');
        }
        else return Response::render();
    }
}
