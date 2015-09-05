<?php
$src_fhm = post()->getLatestPostImage(0)->urlThumbnail(45, 45);
?>
<div class="front-text-with-thumbnail">
<table width="100%" cellspacing="0" cellpadding="0">
    <tr>
        <td width="5%"><img class='thumbnail' src="<?php echo $src_fhm?>"></td>
        <td width="93%">
            <div class="content">
                <h3>Ready Set Dive!</h3>
                <div class="comment">Are you willing to throw yourself...? If yes, folllow me!!</div>
            </div>
        </td>
        <td width="2%"><img src="/theme/default/tmp/fhm.png"</td>
    </tr>
</table>
</div>