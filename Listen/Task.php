<?php
namespace Listen;

class Task 
{
	
	public function run(\swoole_server $serv, $task_id, $from_id, $data)
	{
		\Helper\Log::write(__CLASS__, 'task');
		\Helper\Log::write(__CLASS__, 'task' . $data);

		$serv->finish("$data -> OK");
	}

}