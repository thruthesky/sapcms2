<?php
namespace sap\src;


class Meta {

    private static $loaded;
    private $table = null;
    public function __construct($table) {
        $this->table = $table . '_meta';
    }

    public function install() {
        Entity::init($this->table)
            ->add('idx_target', 'INT')
            ->add('code', 'varchar', 64)
            ->add('value', 'TEXT')
            ->unique('code')
            ->index('idx_target');
        return $this;
    }
    public function unInstall() {
        Database::load()->dropTable($this->table);
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
        $config = Entity::load($this->table, 'code', $code);
        if ( $config ) {
            $config->set('value', $value)
                ->set('idx_target', $target)
                ->save();
        }
        else {
            Entity::create($this->table)
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
    public function get($code=null)
    {
        if ( ! isset(self::$loaded[$code]) ) {
            $entity = Entity::load($this->table, 'code', $code);
            if ( $entity ) self::$loaded[$code] = $entity->value;
            else self::$loaded[$code] = FALSE;
        }
        return self::$loaded[$code];
    }

    public function getEntity($code) {
        $entity = Entity::load($this->table, 'code', $code);
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
        Entity::load($this->table, 'code', $code)->delete();
        unset(self::$loaded[$code]);
        return $this;
    }


    public function group($code)
    {
        return Database::load()->rows($this->table,"code LIKE '$code.%'");
    }

}