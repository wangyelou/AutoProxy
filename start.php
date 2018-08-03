<?php
require_once 'config/autoloader.php';

$server = new swoole_server(IP, PORT);
$server->set(array(
	'worker_num' => WORK_NUM
));
$server->on('Start', array(new \Listen\Start(), 'run'));
$server->on('Receive', array(new \Listen\Receive(), 'run'));
$server->start();

