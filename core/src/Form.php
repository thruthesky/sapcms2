<?php
namespace sap\src;
class Form {
    /**
     * @param $attr
     *  - name
     *  - id
     *  - label
     *  - value
     *  - placeholder
     * @return null|string
     */
    public static function input($attr) {

        if ( ! isset($attr['label']) ) $attr['label'] = $attr['name'];
        if ( ! isset($attr['id']) ) $attr['id'] = $attr['name'];
        if ( ! isset($attr['value']) ) $attr['value'] = '';
        if ( ! isset($attr['placeholder']) ) $attr['placeholder'] = $attr['name'];


        return <<<EOH
<label for="$attr[id]">$attr[label]</label>
<input type="text" name="$attr[name]" data-clear-btn="true" id="$attr[id]" value="$attr[value]" placeholder="$attr[placeholder]">
EOH;
    }
}