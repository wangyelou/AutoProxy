<?php
namespace Task;
/**
 * 码农代理
 * https://proxy.coderbusy.com/classical/country/cn.aspx?page=33
 * @author wangyelou 
 * @date 2018-08-05
 */
class CoderbusyProxy extends \Task\ProxyAbstract
{
	private $url = 'https://proxy.coderbusy.com/classical/country/cn.aspx?page=1';
	private $expression = '/<tr>\s*<td>\s*<a(?!td).+?\/a>([^<]+)<\/td>\s*<td>([^<]+)<\/td>\s*<td[^>]*>([^<]+)<\/td>\s*<td[^>]*>([^<]+)<\/td>\s*<td>\s*<a[^>]+>([^<]+)<\/a>\s*<\/td>\s*<td>([^<]+)<\/td>\s*<td>\s*<span[^>]+>[^<]+<\/span>\s*<\/td>\s*<td>\s*<a[^>]+>([^<]+)<\/a>\s*<\/td>/is';

	public function run()
	{
		$content = $this->curl($this->url);
		if (preg_match_all($this->expression, $content, $matches)) {
			var_dump($matches);
		} else {
			$this->log('匹配失败');
		}
	}

	/**
	 * 抓取数据
	 * @param  [type] $url [description]
	 * @return [type]      [description]
	 */
	private function curl($url)
	{
		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			if (($result = curl_exec($ch)) === false) {
				throw new Exception(curl_error($ch));
			}
		} catch (Exception $e) {
			$this->log($e->getMessage());
		}
		curl_close($ch);
		return $result;
	}

}