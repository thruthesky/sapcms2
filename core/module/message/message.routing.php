<?php

route('/message', 'message\\Message\\collection');
route('/message/send', 'message\\Message\\send');
route('/message/create', 'message\\Message\\messageCreate');
route('/message/delete', 'message\\Message\\messageDelete');

route('/message/markAsRead', 'message\\Message\\markAsRead');