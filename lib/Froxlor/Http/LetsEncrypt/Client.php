<?php
namespace Froxlor\Http\LetsEncrypt;

class Client
{

	private $lastCode;

	private $lastHeader;

	private $base;

	public function __construct($base)
	{
		$this->base = $base;
	}

	private function curl($method, $url, $data = null)
	{
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json'
		);
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, preg_match('~^http~', $url) ? $url : $this->base . $url);
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_HEADER, true);

		// DO NOT DO THAT!
		// curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		// curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

		switch ($method) {
			case 'GET':
				break;
			case 'POST':
				curl_setopt($handle, CURLOPT_POST, true);
				curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
				break;
		}
		$response = curl_exec($handle);

		if (curl_errno($handle)) {
			throw new \RuntimeException('Curl: ' . curl_error($handle));
		}

		$header_size = curl_getinfo($handle, CURLINFO_HEADER_SIZE);

		$header = substr($response, 0, $header_size);
		$body = substr($response, $header_size);

		$this->lastHeader = $header;
		$this->lastCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

		$data = json_decode($body, true);
		return $data === null ? $body : $data;
	}

	public function post($url, $data)
	{
		return $this->curl('POST', $url, $data);
	}

	public function get($url)
	{
		return $this->curl('GET', $url);
	}

	public function getLastNonce()
	{
		if (preg_match('~Replay\-Nonce: (.+)~i', $this->lastHeader, $matches)) {
			return trim($matches[1]);
		}

		$this->curl('GET', '/directory');
		return $this->getLastNonce();
	}

	public function getLastLocation()
	{
		if (preg_match('~Location: (.+)~i', $this->lastHeader, $matches)) {
			return trim($matches[1]);
		}
		return null;
	}

	public function getLastCode()
	{
		return $this->lastCode;
	}

	public function getLastLinks()
	{
		preg_match_all('~Link: <(.+)>;rel="up"~', $this->lastHeader, $matches);
		return $matches[1];
	}
}
