<?php
route('/post', 'post\\post\\index');
route('/post/admin', 'post\\post\\admin');
route('/post/config', 'post\\PostConfig\\index');


route('/post/config/global', 'post\\PostConfig\\globalConfiguration');
route('/post/config/list', 'post\\post\\listPostConfig');
route('/post/config/edit', 'post\\post\\editPostConfig');

route('/post/config/create', 'post\\post\\configCreate');
route('/post/config/create_submit', 'post\\post\\configCreateSubmit');


route('/post/list', 'post\\post\\listPostData');
route('/post/edit', 'post\\post\\editPostData');

