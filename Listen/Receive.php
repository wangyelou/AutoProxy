<?php
namespace Listen;

class Receive 
{
	
	public function run(\swoole_server $serv, $fd, $from_id, $data)
	{
		\Helper\Log::write(__CLASS__, "已接收到数据{$data}");
		$serv->send($fd, "发送数据给你");

		$serv->task("发送task给你_{$data}");
	}

}