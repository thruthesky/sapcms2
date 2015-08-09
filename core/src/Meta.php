<?php
namespace sap\src;


class Meta {

    private static $loaded;
    private $table = null;
    private $group_code = null;

    public function __construct($table) {

        $this->table = $table . '_meta';
    }


    /**
     * @param null $table
     * @return $this|null - If $work_table is null, then it returns a string with table name.
     *
     * - If $create_table is null, then it returns a string with table name.
     *
     * - If $create_table is not null, then it returns $this.
     */
    final public function table($table=null) {
        if ( $table === null ) return $this->table;
        return new Entity($table);
    }

    final public function createTable() {
        entity($this->table())->createTable()
            ->add('idx_target', 'INT')
            ->add('code', 'varchar', 64)
            ->add('value', 'TEXT')
            ->unique('code')
            ->index('idx_target');
        return $this;
    }

    final public function dropTable() {
        return entity($this->table())->dropTable();
    }

    final public function loadTable() {
        entity($this->table())->loadTable();
    }

    /**
     * @param $code
     *      - it can be an array.
     *      - it can be a string.
     * @param null $value
     * @param int $target
     * @return $this
     */
    public function set($code, $value=null, $target=0)
    {
        if ( is_array($code) ) {
            foreach( $code as $key => $value ) {
                $this->set($key, $value);
            }
            return $this;
        }

        $code = $this->getGroupCode() . $code;

        $item = entity($this->table())->load('code', $code);

        if ( $item ) {
            $item->set('value', $value)
                ->set('idx_target', $target)
                ->save();
        }
        else {
            entity($this->table())
                ->set('code', $code)
                ->set('value', $value)
                ->set('idx_target', $target)
                ->save();
        }
        return $this;
    }

    /**
     * @param $code
     * @return mixed
     *
     * @Attention it memory-caches internally.
     */
    final public function get($code)
    {

        $code = $this->getGroupCode() . $code;

        if ( ! isset(self::$loaded[$code]) ) {
            $entity = entity($this->table())->load('code', $code);
            if ( $entity ) self::$loaded[$code] = $entity->get('value');
            else self::$loaded[$code] = FALSE;
        }
        //dog("  --------- CODE:$code\n");
        //dog(self::$loaded[$code]);
        return self::$loaded[$code];
    }

    /**
     *
     *
     */
    final public function gets() {
        $code = $this->getGroupCode();
        $rows = entity($this->table())->rows("code LIKE '$code%'", 'code,value');
        $kvs = [];
        if ( $rows ) {
            foreach( $rows as $row ) {
                self::$loaded[$row['code']] = $row['value'];
                $kvs[$row['code']] = $row['value'];
            }
        }
        return $kvs;
    }


    /**
     * @param $code
     * @return bool|Entity
     *
     *
     * @Attention Since Meta class does not extends, it returns Entity class object to return a Entity item.
     *
     *      - For instance, the delete() below is on Entity class not in Meta class.
     *
     *              config()->getEntity('d')->delete();
     *
     */
    final public function getEntity($code) {
        $entity = entity($this->table())->load('code', $code);
        if ( $entity ) return $entity;
        else return FALSE;
    }

    /**
     *
     * Deletes a code or group of code.
     *
     *  - If the input $code is empty, then it deletes a group.
     *
     * @param $code
     * @return $this
     *
     * @Attention it returns $this to allow chaining.
     *
     * @code
     *      meta('z')->group('meal')->delete();
     * @endcode
     */
    public function delete($code=null) {
        if ( empty($code) ) return $this->group_delete();
        entity($this->table())->load('code', $code)->delete();
        unset(self::$loaded[$code]);
        return $this;
    }


    /**
     * @return $this
     */
    public function group_delete() {
        $code = $this->getGroupCode();
        if ( empty($code) ) return FALSE;
        entity($this->table())->delete("code LIKE '$code%'");
        return $this;
    }


    /**
     * @param $code
     *
     * @see https://docs.google.com/document/d/156a65kERmYVeLOI_PqY_Ixrj8ARWt_nDIVK45C7zmPo/edit#heading=h.4pt2maebnhif
     * @return $this
     */

    public function group($code)
    {
        $this->setGroupCode($code);
        return $this;
    }

    private function setGroupCode($code)
    {
        $this->group_code .= "$code.";
    }
    private function getGroupCode()
    {
        return $this->group_code;
    }

}