<?php
namespace Listen;

class WorkStart 
{

	//运行任务池
	private $taskPool = array();

	public function run(\swoole_server $serv)
	{
		if ($serv->worker_id === 0) {
			\Helper\Log::write(__CLASS__, 'WorkStart');

			//监控ip池，空则调用
			$serv->tick(1000, function ($timeId, $workStart) {		
				if (\Helper\Utility::proxyTable()->count() == 0) {

					foreach ($this->getTasks() as $task) {
						//启动任务
						if (!\Helper\Utility::taskPool()->get($task)) {
							if ($this->startTask($task)) {
								\Helper\Log::write('task_run', "task {$task} start success");
							} else {
								\Helper\Log::write('task_run', "task {$task} start failed");
							}
						}
					}
				}
			}, $this);

			//ip池ip检测
			$serv->tick(1000, function($timerId) {
				$proxyTable = \Helper\Utility::proxyTable();
				if ($proxyTable->count() > 0) {
					\Helper\Log::write('ip_check', 'ip检测');
					foreach ($proxyTable as $key => $item) {
						try {
							\Helper\Utility::checkProxy($item);
						} catch (\Exception $e) {
							\Helper\Log::write('ip_check', "[{$item['ip']}:{$item['port']}] 剔除ip池，". $e->getMessage());
							$proxyTable->del($key);
						}
					}
				}
			});


			//回收子进程
			\swoole_process::signal(SIGCHLD, function($sig) {
			  	//必须为false，非阻塞模式
				  while($ret =  \swoole_process::wait(false)) {
					  	foreach (\Helper\Utility::taskPool() as $key => $item) {
					  		if ($item['pid'] == $ret['pid']) {
					      		\Helper\Utility::taskPool()->del($key);
								\Helper\Log::write(__CLASS__, "task {$key} finished");
					  		}
					  	}
				  }
			});
		}
	}

	/**
	 * 启动任务
	 * @param  string $task 任务名
	 * @return [type]       [description]
	 */
	private function startTask($task)
	{
		$process = new \swoole_process(function (\swoole_process $process) use ($task) {
			$process->name(PROJECT_NAME . ' -task ' . $task);
			\Helper\Utility::taskPool()->set($task, array('pid'=>$process->pid));

			$class = '\Task\\' . $task;
			$task = new $class();
			$task->run();

		}, false);
		return $process->start();
	}


	/**
	 * 获取task列表
	 * @return [type] [description]
	 */
	public function getTasks()
	{
		$files = scandir(BASE_PATH . 'Task' . SEPATATOR);
		foreach ($files as $key => $file) {
			if ($file == '.' || $file == '..' || $file == 'ProxyAbstract.php') {
				unset($files[$key]);
			} else {
				list($files[$key]) = explode('.', $file);
			}
		}
		return $files;
	}



}