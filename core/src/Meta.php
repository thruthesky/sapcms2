<?php
namespace sap\src;


class Meta {

    private static $loaded;
    private $table = null;
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
        entity($this->table)->createTable()
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
     * @param null $code
     * @return mixed
     *
     * @Attention it memory-caches internally.
     */
    final public function get($code=null)
    {
        if ( ! isset(self::$loaded[$code]) ) {
            $entity = entity($this->table())->load('code', $code);
            if ( $entity ) self::$loaded[$code] = $entity->get('value');
            else self::$loaded[$code] = FALSE;
        }
        return self::$loaded[$code];
    }


    final public function getEntity($code) {
        $entity = entity($this->table())->load('code', $code);
        if ( $entity ) return $entity;
        else return FALSE;
    }

    /**
     * @param $code
     * @return $this
     *
     * @Attention it returns $this to allow chaining.
     */
    public function delete($code) {
        entity($this->table())->load('code', $code)->delete();
        unset(self::$loaded[$code]);
        return $this;
    }

    /**
     * @param $code
     *
     * @todo 아래의 코드 처럼 그룹 관리를 할 수 있게 하고, 그룹 로드를 할 수 있게 한다.
     *
    meta('z')->group('meal')->set('breakfast', 'fruits and milk');
    meta('z')->group('meal')->set('lunch', 'beef and milk');
    meta('z')->group('meal')->set('dinner', 'bread and milk');

    meta('z')->group('user')->group('jaeho')->set('name', 'JaeHo Song');
    meta('z')->group('user')->group('jaeho')->set('age', '41');
    meta('z')->group('user')->group('jaeho')->set('gender', 'M');
    meta('z')->group('user')->group('jaeho')->set('address', 'Balibago');

    meta('z')->group('user')->group('woobum')->set('name', 'Woo Beom Jung');
    meta('z')->group('user')->group('woobum')->set('age', '39');
    meta('z')->group('user')->group('woobum')->set('gender', 'M');
    meta('z')->group('user')->group('woobum')->set('address', 'Balibago');
     */

    public function group($code)
    {
        return null;
    }

}