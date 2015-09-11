<?php
$a1 = widget()->loadParseIni();
$a2 = widget()->loadParseIni("core/module/post/widget/*");
$a3 = widget()->loadParseIni();
$a4 = widget()->loadParseIni("core/module/post/widget/*");



print_r($a4);
print_r($a4['post_list']);






//$i1 = widget()->ini('post_list');
//$i2 = get_widget_ini('post_list', "core/module/post/widget/*");
//$i3 = array_merge($i1, $i2);



