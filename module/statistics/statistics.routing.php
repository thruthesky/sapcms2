<?php

// Admin Page
//route('/admin/post/config/create', 'post\\post\\configCreate');
//route('/admin/post/config/edit', 'post\\post\\adminPostConfigEdit');

route('/admin/statistics', 'statistics\\statistics\\index');
route('/admin/statistics/user', 'statistics\\statistics\\user');
route('/admin/statistics/post', 'statistics\\statistics\\post');
