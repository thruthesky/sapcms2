<?php


/**
 * @Attention PHP7 Builtin Web Server does not support '/data' path. I do not know why.
 *  - use /file/xxxxx instead of /route/xxxxx
 *
 */
route('/file/upload', 'data\\DataController\\upload');