<?php
add_css();
?>

<div class='title default'>Block Numbers</div>
<div class='notice error'>
Blocking numbers will stop a number from getting inside queue.<br>
Previously queued numbers will still execute.
</div>

<?php include template('smsgate.menu'); ?>
<form method="post">


    Numbers :
    <textarea name="numbers"></textarea>


    Reason :
    <textarea name="reason"></textarea>
    <input type="submit" value="BLOCK">

</form>