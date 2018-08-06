<?php
namespace Listen;

class Start 
{
	
	public function run(\swoole_server $serv)
	{
		\Helper\Log::write(__CLASS__, 'start');




	}

}