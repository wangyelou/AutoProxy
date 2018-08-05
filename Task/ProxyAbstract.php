<?php
namespace Task;
class ProxyAbstract
{


	protected function log($msg)
	{
		echo date('Y-m-d H:i:s') . ' ' . $msg . PHP_EOL;
	}

}