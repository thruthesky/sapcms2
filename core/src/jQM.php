<?php
namespace sap\src;
class jQM {

    private $fields = [];
    private $item = [];
    private $widget = null;
    private $widget_tag = null;

    public function __get($field) {
        return $this->get($field);
    }
    public function __set($field, $value) {
        return $this->set($field, $value);
    }

    /**
     * @param null $field
     * @return array|null
     */
    public function get($field=null)
    {
        if ( $field ) {
            return isset($this->fields[$field]) ? $this->fields[$field] : null;
        }
        else {
            return $this->fields;
        }
    }

    /**
     * @param $field
     * @param null $value
     * @return $this
     */
    public function set($field, $value=null)
    {
        if ( is_array($field) ) {
            $this->fields = array_merge($this->fields, $field);
        }
        else $this->fields[$field] = $value;
        return $this;
    }


    public function __toString() {
        switch ( $this->widget ) {
            case 'listview' : return $this->renderListview();
        }
        return print_r($this, true);
    }

    public function item($item=null) {
        $this->item[] = $item;
        return $this;
    }

    public function listview($tag = 'OL') {
        $this->widget = 'listview';
        $this->widget_tag = $tag;
        return $this;
    }

    private function renderListview()
    {
        $tag = $this->widget_tag;
        $re = "<$tag data-role='listview'>" . PHP_EOL;
        $re .= "<LI>" . implode("</LI>".PHP_EOL."<LI>", $this->item) . "</LI>" . PHP_EOL;
        $re .= "</$tag>" . PHP_EOL;
        return $re;
    }
}
