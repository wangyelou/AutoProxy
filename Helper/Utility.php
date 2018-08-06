<?php
namespace Helper;
/**
 * 公告方法
 * @author wangyelou
 * @date 2018-08-06
 */
class Utility
{
	private static $table;

	/**
	 * 返回内存table句柄
	 * @return [type] [description]
	 */
	public static function proxyTable()
	{
		if (!self::$table) {
			self::$table = new \Swoole\Table(IP_NUM);
			self::$table->column('ip', \Swoole\Table::TYPE_STRING, 20);
			self::$table->column('port', \Swoole\Table::TYPE_INT, 20);
			self::$table->column('location', \Swoole\Table::TYPE_STRING, 1024);
			self::$table->column('type', \Swoole\Table::TYPE_STRING, 20);
			self::$table->column('transparency', \Swoole\Table::TYPE_STRING, 20);
			self::$table->column('https', \Swoole\Table::TYPE_INT, 1);
			self::$table->column('post', \Swoole\Table::TYPE_INT, 1);
			self::$table->column('consume', \Swoole\Table::TYPE_FLOAT, 20);
			self::$table->create();
		}
		return self::$table;
	}


}
