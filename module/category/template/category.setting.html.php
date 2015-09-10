<form action="/admin/category/setting/submit" method="post">

    Name:
    <input type="text" name="name"><br>
    Description:
    <input type="text" name="description"><br>
    <input type="submit">

</form>

<?php

di( category()->rows() );