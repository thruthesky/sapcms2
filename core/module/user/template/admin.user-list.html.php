<?php
use sap\src\HTML;
use sap\src\Request;

$no_item = sysconfig(NO_ITEM);
$no_page = sysconfig(NO_PAGE);

if ( $word = Request::get('word') ) {
    $cond = "id LIKE '%$word%' or name LIKE '%$word%' or mail LIKE '$word%'";
}
else $cond = null;

$total_record = user()->count($cond);
$from = (page_no()-1) * $no_item;
$rows = user()->rows("$cond limit $from, $no_item");
?>
<form>
    <table>
        <tr>
            <td><input type="text" name="word" placeholder="Search id, name, mail"></td>
            <td><input type="submit" value="SEARCH"></td>
        </tr>
    </table>
</form>

<?php echo $word ? 'No of search result' : 'No of users'; ?> :
<?php echo $total_record; ?>
&nbsp; [ <a href="?">clear search</a> ]

<table data-role="table" id="table-module-list" data-mode="columntoggle" class="ui-responsive table-stroke">
    <thead>
    <tr>
        <th data-priority="2">No.</th>
        <th>ID</th>
        <th data-priority="1">Name</th>
        <th data-priority="3">Email</th>
        <th data-priority="1">Edit</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach( $rows as $user ) {
        echo "<tr>";
        echo "<td><a href='/admin/user/edit?idx=$user[idx]'>$user[idx]</a></td>";
        echo "<td>$user[id]</td>";
        echo "<td>$user[name]</td>";
        echo "<td>$user[mail]</td>";
        echo "<td>Edit</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<style>
    nav.navigation-bar a {
        display:inline-block;
        margin:0 1px;
        padding:4px 6px;
        background-color: #d3e8f4;
        border-radius: 2px;
    }
</style>
<?php
echo HTML::paging(page_no(), $total_record, $no_item, $no_page);



