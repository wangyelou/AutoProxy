<?php

$client = new swoole_client(SWOOLE_SOCK_TCP);
if (!$client->connect('127.0.0.1', 9230, -1))
{
    exit("connect failed. Error: {$client->errCode}\n");
}
$client->send(json_encode(array(
	'type' => 'all'//'all'
)));
$result = $client->recv();
$client->close();

$result = json_decode($result, true);

print_r($result);