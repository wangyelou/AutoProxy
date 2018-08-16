<?php
namespace Helper;
/**
 * 公告方法
 * @author wangyelou
 * @date 2018-08-06
 */
class Utility
{
	private static $proxy;
	/**
	 * 返回内存table句柄
	 * @return [type] [description]
	 */
	public static function proxyTable()
	{
		if (!self::$proxy) {
			self::$proxy = new \Swoole\Table(IP_NUM);
			self::$proxy->column('ip', \Swoole\Table::TYPE_STRING, 20);
			self::$proxy->column('port', \Swoole\Table::TYPE_INT, 20);
			self::$proxy->column('location', \Swoole\Table::TYPE_STRING, 1024);
			self::$proxy->column('type', \Swoole\Table::TYPE_STRING, 20);
			self::$proxy->column('transparency', \Swoole\Table::TYPE_STRING, 20);
			self::$proxy->column('https', \Swoole\Table::TYPE_INT, 1);
			self::$proxy->column('post', \Swoole\Table::TYPE_INT, 1);
			self::$proxy->column('consume', \Swoole\Table::TYPE_FLOAT, 20);
			self::$proxy->create();
		}
		return self::$proxy;
	}

	private static $task;
	/**
	 * 返回正在运行task内存句柄
	 * @return [type] [description]
	 */
	public static function taskPool()
	{
		if (!self::$task) {
			self::$task = new \Swoole\Table(20*100);
			self::$task->column('pid', \Swoole\Table::TYPE_INT, 10);
			self::$task->create();
		}
		return self::$task;
	}

	/**
	 * 代理检测
	 * @param  array $data [description]
	 * @return [type]       [description]
	 */
	public static function checkProxy($data)
	{
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
		curl_close($ch);
		return $data;
	}


}
