<?php
namespace sap\post;


use sap\src\Entity;
use sap\src\Response;

class PostConfig extends Entity {
    public function __construct() {
        parent::__construct(POST_CONFIG);
    }

    public static function collection() {
        return Response::render(['template'=>'post.config.list']);
    }


}
