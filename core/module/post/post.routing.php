<?php

// Admin Page
route('/admin/post/config/create', 'post\\post\\configCreate');
route('/admin/post/config/edit', 'post\\post\\adminPostConfigEdit');
route('/admin/post/config/create_submit', 'post\\post\\configCreateSubmit');
route('/admin/post/config/edit_submit', 'post\\post\\adminPostConfigEditSubmit');
route('/admin/post/config/delete_submit', 'post\\post\\configDeleteSubmit');

route('/admin/post/config/list', 'post\\post\\adminPostConfigList');

route('/admin/post/config/global', 'post\\post\\adminPostConfigGlobal');




route('/post', 'post\\post\\index');
route('/post/admin', 'post\\post\\admin');
route('/post/config', 'post\\PostConfig\\index');


route('/post/config/global', 'post\\PostConfig\\globalConfiguration');
route('/post/config/list', 'post\\post\\listPostConfig');
route('/post/config/edit', 'post\\post\\editPostConfig');

route('/post/list', 'post\\post\\postList');

route('/post/create/*', 'post\\post\\postCreate');
route('/post/create/submit', 'post\\post\\postCreateSubmit');

route('/post/edit/*', 'post\\post\\postEdit');
route('/post/edit/submit', 'post\\post\\postEditSubmit');

route('/post/comment/submit', 'post\\post\\postCommentSubmit');
route('/post/comment/edit', 'post\\post\\postCommentEdit');
route('/post/comment/edit/submit', 'post\\post\\postCommentEditSubmit');
route('/post/view', 'post\\post\\postView');

route('/post/data/delete/*', 'post\\post\\postDataDelete');



route('/post/search', 'post\\post\\searchPostData');



route('/post/vote/good/*', 'post\\post\\voteGood');
route('/post/vote/bad/*', 'post\\post\\voteBad');

route('/post/report/*', 'post\\post\\report');
route('/post/reportSubmit', 'post\\post\\reportSubmit');
route('/post/reportList', 'post\\post\\reportList');