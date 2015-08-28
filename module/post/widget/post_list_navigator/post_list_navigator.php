<?php
use sap\src\HTML;

add_css();
$variables = module()->getVariables();

$no_item = post()->config(NO_ITEM);
$no_page = post()->config(NO_PAGE);

$total_record = $variables['total_record'];
echo "Total record: $variables[total_record]";
echo HTML::paging(page_no(), $total_record, $no_item, $no_page);
