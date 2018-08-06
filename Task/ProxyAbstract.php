<?php
namespace Task;
class ProxyAbstract
{

	protected function log($msg)
	{
		$string = date('Y-m-d H:i:s') . ' ' . $msg . PHP_EOL;
		//file_put_contents('/tmp/proxy', $string, FILE_APPEND);
		echo $string;
	}

	/**
	 * 放入ip池
	 * @param  string $data [description]
	 * @return [type]       [description]
	 */
	protected function setTable($data)
	{
		$table = \Helper\Utility::proxyTable();
		$table->set(md5($data['ip'].$data['port']), $data);
		$this->log("[{$data['ip']}:{$data['port']}] success");
	}


	/**
	 * 检查代理
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	protected function checkProxy($data)
	{
		$data['ip'] = '192.155.185.18';
		$data['port'] = '80';
		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://www.baidu.com/');
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_PROXY, $data['ip']);
			curl_setopt($ch, CURLOPT_PROXYPORT, $data['port']);
			$startTime = microtime(true);
			if (($result = curl_exec($ch)) === false) {
				throw new \Exception(curl_error($ch));
			}
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($httpcode > 400) {
				throw new \Exception("HTTP CODE {$httpcode}");
			}
			$data['consume'] = round((microtime(true) - $startTime) * 1000, 2);
		} catch (\Exception $e) {
			$this->log("[{$data['ip']}:{$data['port']}] ". $e->getMessage());
			return false;
		}
		curl_close($ch);
		return $data;
	}

}