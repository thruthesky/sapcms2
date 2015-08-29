<a class="ui-btn ui-btn-inline" href="/admin/post/config/global">Global Config</a>
<a class="ui-btn ui-btn-inline" href="/admin/post/config/create">Post Config Create</a>
<a class="ui-btn ui-btn-inline" href="/admin/post/config/list">Post Config List</a>
<a class="ui-btn ui-btn-inline" href="/admin/post/block/list">Block List</a>
<a class="ui-btn ui-btn-inline" href="/admin/post/blind/list">Blind List</a>
<a class="ui-btn ui-btn-inline" href="/admin/post/report/list">Report List</a>
<?php
if ( $config = post_config()->getCurrent() ) {
?>
    <a class="ui-btn ui-btn-inline" href="<?php echo url_post_list() ?>">Post List</a>
<?php
}
?>
