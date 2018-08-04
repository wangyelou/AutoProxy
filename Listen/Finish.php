<?php
namespace Listen;

class Finish 
{
	
	public function run(\swoole_server $serv, $task_id, $data)
	{
		\Helper\Log::write(__CLASS__, 'finish');
	}

}