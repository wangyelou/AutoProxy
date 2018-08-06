<?php
namespace Listen;

class WorkStart 
{
	public function run(\swoole_server $serv)
	{
		if ($serv->worker_id === 0) {
			\Helper\Log::write(__CLASS__, 'WorkStart');
			$timerId = $serv->after(1000, function() {
				 $task = new \Task\CoderbusyProxy();
				 $task->run();
			});
			var_dump($timerId);
		}


		//var_dump($result);


	}



}