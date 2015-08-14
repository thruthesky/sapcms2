<?php
namespace sap\bulk;


use sap\src\Response;

class bulk {
    public static function index() {
        return Response::render();
    }
    public static function create() {
        if ( submit() ) {
            //di( entity(BULK_DATA)->count() );
            entity(BULK)
                ->set('name', request('name'))
                ->set('message', request('message'))
                ->save();
            return Response::redirect('/bulk');
        }
        else return Response::render();
    }
}
