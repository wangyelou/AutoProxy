<?php
define('SEPATATOR', strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'?'\\':'/');
define('BASE_PATH',dirname(dirname(__FILE__)).SEPATATOR);
define('EXT','php');
define('IP', '0.0.0.0');
define('PORT', 9230);
define('WORK_NUM', 1);