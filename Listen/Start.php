<?php
namespace Listen;

class Start 
{
	
	public function run()
	{
		\Helper\Log::write(__CLASS__, 'start');

		$task = new \Task\CoderbusyProxy();
		$task->run();

	}

}