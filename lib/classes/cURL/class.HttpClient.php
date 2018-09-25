<?php

class HttpClient
{

	/**
	 * Executes simple GET request
	 *
	 * @param string $url
	 *
	 * @return array
	 */
	public static function urlGet($url, $follow_location = true)
	{
		include FROXLOR_INSTALL_DIR . '/lib/version.inc.php';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Froxlor/' . $version);
		if ($follow_location) {
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		if ($output === false) {
			$e = curl_error($ch);
			curl_close($ch);
			throw new \Exception("Curl error: " . $e);
		}
		curl_close($ch);
		return $output;
	}
	
	/**
	 * Downloads and stores a file from an url
	 *
	 * @param string $url
	 * @param string $target
	 *
	 * @return array
	 */
	public static function fileGet($url, $target)
	{
		include FROXLOR_INSTALL_DIR . '/lib/version.inc.php';
		$fh = fopen($target, 'w');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Froxlor/' . $version);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		//give curl the file pointer so that it can write to it
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FILE, $fh);
		$output = curl_exec($ch);
		if ($output === false) {
			$e = curl_error($ch);
			curl_close($ch);
			throw new \Exception("Curl error: " . $e);
		}
		curl_close($ch);
		return $output;
	}
}
