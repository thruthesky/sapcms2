<?php
namespace sap\core;
class Markup {
    protected $type = null;
    protected $storage = [];
    public function get($k)
    {
        if ( isset($this->storage[$k]) ) return $this->storage[$k];
        else return null;
    }
    public function set($k, $v) {
        $this->storage[$k] = $v;
        return $this;
    }

    public function display() {
        if ( $this->storage ) {
            if ( $this->storage['type'] == 'box' ) {
                $title = $this->get('title');
                $content = $this->get('content');
            }
            else if ( $this->storage['type'] == 'box.error' ) {
                $title = $this->get('code');
                $content = $this->get('message');
            }
            $class = $this->get('class');
            $type = $this->get('type');
            $row = self::row(['class'=>$class, 'caption'=>$title, 'text'=>$content]);
            return <<<EOH
        <section class="$type">
        $row
        </section>
EOH;
        }
    }

    public static function create() {
        return new Markup();
    }



    public static function row($arg) {

        return <<<EOH
        <div class="row $arg[class]">
            <div class="caption">$arg[caption]</div>
            <div class="text">$arg[text]</div>
        </div>
EOH;
    }



}
