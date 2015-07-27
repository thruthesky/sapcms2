<?php
if ( Request::install() ) {
    include $system->module(true)->script();
    exit;
}
else {
    if ( ! $system->install() ) Response::redirect('?act=install.form');
}
