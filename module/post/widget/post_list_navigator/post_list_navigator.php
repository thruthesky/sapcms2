<?php
use sap\src\HTML;

add_css();

$no_item = sysconfig(NO_ITEM);
$no_page = sysconfig(NO_PAGE);
$total_record = $variables['total_record'];
echo HTML::paging(page_no(), $total_record, $no_item, $no_page);
