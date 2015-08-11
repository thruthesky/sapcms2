<?php
namespace sap\dog;

use sap\src\Response;

class Stat {


    public static function access()
    {
        $count = dog()->count();
        Response::render(['template'=>'dog.stat.access.html.twig', 'data'=>$count, 'name'=>'abc']);
    }
}
