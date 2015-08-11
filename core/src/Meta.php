<?php
namespace sap\src;


class Meta extends Entity {

    private $group_code = null;

    public function __construct($table) {
        parent::__construct($table . '_meta');
    }


    /**
     * @param null $table
     * @return $this|null - If $work_table is null, then it returns a string with table name.
     *
     * - If $create_table is null, then it returns a string with table name.
     *
     * - If $create_table is not null, then it returns $this.
     */
    /*
    final public function table($table=null) {
        if ( $table === null ) return $this->table;
        return new Entity($table);
    }
    */

    final public function createTable() {
        parent::createTable()
            ->add('idx_target', 'INT')
            ->add('code', 'varchar', 64)
            ->add('value', 'TEXT')
            ->unique('code')
            ->index('idx_target');
        return $this;
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

        // $item = entity($this->table())->load('code', $code);

        if ( $this->load('code', $code) ) {
            parent::set('value', $value);
            parent::set('idx_target', $target);
            parent::save();
        }
        else {
            //$this->fields['code'] = $code;
            //$this->fields['value'] = $value;
            parent::set('code', $code);
            parent::set('value', $value);
            parent::set('idx_target', $target);


            $this->save();

        }
        $this->clearLoadCache($this->table().":code:$code");
        return $this;
    }

    /**
     *
     * Returns value of a code or Values of a group.
     *
     *      - If the input $code is empty, then it returns values of group.
     *
     * @param $code
     * @return mixed
     *
     * @Attention it does not memory cache since load() is cached in parent object already.
     *
     *
     *
     */
    final public function value($code)
    {
        $code = $this->getGroupCode() . $code;

        if ( $this->load('code', $code) ) return $this->get('value');
        else return FALSE;
    }


    /**
     * Returns an array of codes (without values) of a group.
     * @return array
     */
    final public function codes() {
        $arr = $this->gets();
        return array_keys($arr);
    }


    /**
     * Returns an array of values (without code) of a group.
     * @return array
     */
    final public function values() {
        $arr = $this->gets();
        return array_values($arr);
    }



    /**
     *
     * Returns keys and values of a group.
     *
     * @return array
     */
    final public function gets() {
        $code = $this->getGroupCode();
        $rows = $this->rows("code LIKE '$code%'", 'code,value');
        $kvs = [];
        if ( $rows ) {
            foreach( $rows as $row ) {
                //self::$loaded[$row['code']] = $row['value'];
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
     *
     */
    final public function getEntity($code) {
        $code = $this->getGroupCode() . $code;
        return $this->load('code', $code);
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
    /*
    public function delete($code=null) {
        if ( empty($code) ) return $this->group_delete();
        //entity($this->table())->load('code', $code)->delete();
        parent::delete("code='$code'");
        //unset(self::$loaded[$code]);
        return $this;
    }
    */


    /**
     * @return $this
     */
    public function group_delete() {
        $code = $this->getGroupCode();
        if ( empty($code) ) return FALSE;
        //entity($this->table())->delete("code LIKE '$code%'");
        parent::delete("code LIKE '$code%'");
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