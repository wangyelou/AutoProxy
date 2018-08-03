<?php
require_once 'config.php';

function loadClass($class) {
	$file = BASE_PATH . strtr($class, '\\', SEPATATOR) . '.' . EXT;
	if (file_exists($file)) {
		require_once $file;
	}
}
spl_autoload_register('loadClass');