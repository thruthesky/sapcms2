<?php

route('/message/list', 'message\\Message\\collection');
route('/message/send', 'message\\Message\\send');
route('/message/create', 'message\\Message\\messageCreate');