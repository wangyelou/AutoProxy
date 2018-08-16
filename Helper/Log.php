<?php
namespace Helper;

class Log
{
	public static function write($type, $msg)
	{
		$content = date('Y-m-d H:i:s') . ' ' . $msg . PHP_EOL;
		file_put_contents(LOG_PATH . $type. '.log', $content, FILE_APPEND);
	}

}