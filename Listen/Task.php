<?php
namespace Listen;

class Task 
{
	
	public function run(\swoole_server $serv, $task_id, $from_id, $data)
	{
		\Helper\Log::write(__CLASS__, 'task');
		\Helper\Log::write(__CLASS__, 'task' . $data);

		list(, $name) = explode('_', $data);
		swoole_set_process_name(trim($name));
		sleep(120);

		$serv->finish("$data -> OK");
	}

}