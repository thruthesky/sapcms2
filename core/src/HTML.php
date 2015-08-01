<?php
namespace sap\src;
class HTML {

    protected $meta = [];
    protected $body = null;
    protected $title = null;
    protected $content = null;

    public static function create()
    {
        return new HTML();
    }

    public function meta($key, $value)
    {
        $this->meta[$key] = $value;
        return $this;
    }

    public function body($html)
    {
        $this->body = $html;
    }
    public function get()
    {
        $m = "<!doctype html>";
        $m .= "<html>\n";
        $m .= "<head>\n";
        foreach( $this->meta as $k => $v ) {
            $m .= "<meta $k='$v'>\n";
        }
        $m .= "</head>\n";
        $m .= $this->body;
        $m .= "<body>\n";
        $m .= "</body>\n";
        $m .= "</html>\n";
        return $m;
    }

    public function box($attr)
    {
    }
}