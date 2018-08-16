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
		try {
			return \Helper\Utility::checkProxy($data);
		} catch (\Exception $e) {
			$this->log("[{$data['ip']}:{$data['port']}] ". $e->getMessage());
			return false;
		}
	}

	/**
	 * @param string $url [<description>]
	 * [setCurl description]
	 */
	protected function returnCurl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		return $ch;
	}

}