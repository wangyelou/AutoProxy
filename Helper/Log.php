<?php
namespace Helper;

class Log
{
	public static function write($type, $msg)
	{
		echo date('Y-m-d H:i:s') . ' ' . $msg . PHP_EOL;
	}

}