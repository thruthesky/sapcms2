<?php
/**
 *
 * @input $widget['total_record'] - the total record.
 */
use sap\src\HTML;

add_css();

$no_item = post()->config(NO_ITEM);
$no_page = post()->config(NO_PAGE);

$total_record = post()->postListDataCount();

echo "Total record: $total_record";

$qs = request();
unset($qs["page_no"]);
unset($qs["idx"]);
unset($qs["idx_comment"]);
$qs['id'] = post()->getCurrentConfig('id');
$q = http_build_query($qs);
if ( segment(1) == 'search' ) $path = "/post/search";
else $path = "/post/list";
echo HTML::paging(page_no(), $total_record, $no_item, $no_page, null, $q, $path);
