<?php
namespace sap\core;
/**
 * Class SQL
 * @package sap\core
 *
 *
 * $where = SQL::where('AND')
->add('idx', '55', '>')
->add('id', '%the%', 'like')
->get();
 *
 *
 *

$where = SQL::where('OR')
->add('idx', '55', '>')
->add('id', '%the%', 'like')
->add('email', 'abc@gmail.com')
->add(
SQL::where('AND')
->add('a', 'b')
->add('c', 'd')
->get()
)
->get();
 *
 */
class SQL {
    private $default_expression = null;
    private $conds = [];

    public static function where($exp='AND') {
        $sql = new SQL();
        $sql->default_expression = $exp;
        return $sql;
    }

    public function condition($name, $value=null, $exp=null) {
        return $this->add($name, $value, $exp);
    }
    public function add($name, $value=null, $exp=null) {
        if ( $value === null && $exp === null ) {
            if ( $name instanceof SQL ) {
                $this->conds[] = $name->get();
            }
            else {
                $this->conds[] = $name;
            }
        }
        else {
            if ( $exp === null ) $exp = '=';
            $this->conds[] = "`$name` $exp '$value'";
        }
        return $this;
    }
    public function __toString()
    {
        return $this->get();
    }
    public function get() {
        return '(' . implode(' ' . $this->default_expression . ' ', $this->conds) . ')';
    }
}


