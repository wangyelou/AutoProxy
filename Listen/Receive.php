<?php
namespace Listen;

class Receive 
{
	
	public function run(\swoole_server $serv, $fd, $from_id, $receiveData)
	{
		$table = \Helper\Utility::proxyTable();

		$data = array();
		if ($receiveData) {
			if ($param = json_decode($receiveData, true)) {
				if ($param['type'] == 'all') {
					foreach ($table as $key => $item) {
						$data[] = $item;
					}					
				} else if ($param['type'] == 'single') {
					$rand = mt_rand(0, $table->count()-1);
					$i = 0;
					foreach ($table as $key => $item) {
						if ($i++ == $rand) {
							$data = $item;
							break;
						}
					}
				}
			}
		}

		$serv->send($fd, $this->formatSend($data));
	}

	/**
	 * 格式化输出
	 * @param  array $data [description]
	 * @return array       [description]
	 */
	private function formatSend($data)
	{
		if (count($data) == 0) {
			$code = '-1';
			$msg = 'get ip failed';
			$data = array();
		} else {
			$code = '0';
			$msg = 'get ip success';
		}
		return json_encode(array(
			'code' => $code,
			'msg' => $msg,
			'data' => $data
		), JSON_UNESCAPED_UNICODE);
	}

}