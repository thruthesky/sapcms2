<?php
use sap\core\SQL;
$where = db_and()
    ->condition('idx', '55', '>')
    ->condition('id', 'thru%', 'like')
    ->condition(
        db_or()
            ->condition('gender', 'M')
            ->condition('birth_year', 1970, '>')
    );
echo $where;