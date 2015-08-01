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
echo "\n";

$where = db_cond('a', 'A%', 'like')
    ->condition(
        db_or()
            ->condition(
                db_and()
                    ->condition('b', 'B%', 'like')
                    ->condition('c', 'C%', 'like')
            )
            ->condition(
                db_and()
                    ->condition('b', 'B')
                    ->condition('c', 'C')
            )
    );
echo $where;