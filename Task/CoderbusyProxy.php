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
	private $url = 'https://proxy.coderbusy.com/article/2498.aspx';
	private $expression = '/([^\:^\n]+)\:(\d+)\@([A-Z]+)\#\[([^\]]+)\]([^\#^<]+)(\#支持HTTPS)?(\#支持POST)?/is';

	public function run()
	{
		$content = $this->curl($this->url);
		if (preg_match_all($this->expression, $content, $matches)) {
			foreach ($matches[1] as $key => $item) {
				$data = array(
					'ip' => trim(strip_tags($matches[1][$key])),
					'port' => trim($matches[2][$key]),
					'location' => trim($matches[5][$key]),
					'type' => trim($matches[3][$key]),
					'transparency' => trim($matches[4][$key]),
					'https' => empty($matches[6][$key]) ? false : true,
					'post' => empty($matches[7][$key]) ? false : true,
				);
				if ($data = $this->checkProxy($data)) {
					$this->setTable($data);
				}
			}

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
			curl_setopt($ch, CURLOPT_PROXY, '192.155.185.18');
			curl_setopt($ch, CURLOPT_PROXYPORT, 80);
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