<?php
require_once 'config/autoloader.php';

swoole_set_process_name('AutoProxy');
$server = new swoole_server(IP, PORT);
$server->set(array(
	'worker_num' => WORK_NUM,
	'task_worker_num' => TASK_WORK_NUM
));
$server->on('Start', array(new \Listen\Start(), 'run'));
$server->on('WorkerStart', array(new \Listen\WorkStart(), 'run'));
$server->on('Receive', array(new \Listen\Receive(), 'run'));
$server->on('Task', array(new \Listen\Task(), 'run'));
$server->on('Finish', array(new \Listen\Finish(), 'run'));
\Helper\Utility::proxyTable();

$server->start();