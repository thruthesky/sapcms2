<?php

?>
<form action="/admin/theme/config/submit" method="post" data-ajax="false">
    <?php
    $domain = html_input([
        'name' => 'domain',
        'placeholder' => '',
    ]);
    echo html_row([
        'caption' => 'Domain',
        'text' => $domain,
    ]);

    $theme = html_input([
        'name' => 'theme',
        'placeholder' => '',
    ]);
    echo html_row([
        'caption' => 'Theme',
        'text' => $theme,
    ]);
    ?>
    <input type="submit" value="SUBMIT">
</form>


<?php
$rows = theme_config()->rows();
if ( $rows ) {
    echo "<table>";
    echo "<tr><th>Domain</th><th>Theme</th><th>Delete</th></tr>";
    foreach ( $rows as $row ) {
        echo "<tr>";
        echo "<td>$row[code]</td>";
        echo "<td>$row[value]</td>";
        echo "<td><a href='/admin/theme/config/delete/$row[idx]'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}
