<?php

$number = 12345678901;
$message = 'This is the Text message';


for($i=0; $i<1000; $i++) {

    entity(QUEUE)
        ->create()
        ->set('number', "$number$i")
        ->set('message', "$i - $message")
        ->set('priority', 0)
        ->set('user_agent', "php-script")
        ->save();

}