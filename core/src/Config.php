<?php
namespace sap\core;
class Config
{
    private $file = null;
    private $data = null;
    public static function create() {
        return new Config();
    }
    public function file($file) {
        $this->file = $file;
        return $this;
    }
    public function data($data) {
        $this->data = $data;
        return $this;
    }
    public function save() {
        return File::save_in_php(
            $this->file,
            $this->data
            );
    }
}