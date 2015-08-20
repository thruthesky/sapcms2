<?php
route('/post', 'post\\post\\index');
route('/post/admin', 'post\\post\\admin');
route('/post/config', 'post\\PostConfig\\index');


route('/post/config/global', 'post\\PostConfig\\globalConfiguration');
route('/post/config/list', 'post\\PostConfig\\collection');
route('/post/config/edit', 'post\\PostConfig\\edit');

route('/post/config/create', 'post\\post\\configCreate');
route('/post/config/create_submit', 'post\\post\\configCreateSubmit');


route('/post/list', 'post\\post\\search');

