<?php
entity('stress')->createTable()
    ->add('name', 'varchar')
    ->add('subject', 'varchar')
    ->add('content', 'text')
    ->add('no', 'int unsigned')
    ->index('name');
