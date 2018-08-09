<?php
namespace Task;
/**
 * XiciDaili
 * http://www.xicidaili.com/wn/1
 * @author wangyelou 
 * @date 2018-08-09
 */
class XiciProxy extends \Task\ProxyAbstract
{
	private $url = 'http://www.xicidaili.com/wn/1';
	private $expression = '/<tr\s+class="odd">\s*<td[^>]+>\s*<img[^>]+>\s*<\/td>\s*<td[^>]*>([^<]+)<\/td>\s*<td[^>]*>([^<]+)<\/td>\s*<td[^>]*>\s*<a[^>]*>([^>]+)<\/a>\s*<\/td>\s*<td[^>]*>([^<]+)<\/td>\s*<td[^>]*>([^<]+)<\/td>/is';

	public function run()
	{
		$content = $this->curl($this->url);
		if (preg_match_all($this->expression, $content, $matches)) {
			foreach ($matches[1] as $key => $item) {
				$data = array(
					'ip' => trim(strip_tags($matches[1][$key])),
					'port' => trim($matches[2][$key]),
					'location' => trim($matches[3][$key]),
					'type' => trim($matches[5][$key]),
					'transparency' => trim($matches[4][$key]),
					'https' => true,
					'post' => false,
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
			$ch = $this->returnCurl($url);
			if (($result = curl_exec($ch)) === false) {
				throw new \Exception(curl_error($ch));
			}
		} catch (\Exception $e) {
			$this->log($e->getMessage());
		}
		curl_close($ch);
		return $result;
	}

}