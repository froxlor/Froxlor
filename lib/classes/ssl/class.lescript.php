<?php
// Copyright (c) 2015, Stanislav Humplik <sh@analogic.cz>
// All rights reserved.
//
// Redistribution and use in source and binary forms, with or without
// modification, are permitted provided that the following conditions are met:
// * Redistributions of source code must retain the above copyright
// notice, this list of conditions and the following disclaimer.
// * Redistributions in binary form must reproduce the above copyright
// notice, this list of conditions and the following disclaimer in the
// documentation and/or other materials provided with the distribution.
// * Neither the name of the <organization> nor the
// names of its contributors may be used to endorse or promote products
// derived from this software without specific prior written permission.
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
// ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
// WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
// DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
// DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
// (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
// LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
// ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
// (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
// SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

// This file is copied from https://github.com/analogic/lescript
// and modified to work without files and integrate in Froxlor
class lescript
{

	// https://letsencrypt.org/repository/

	private $logger;

	private $client;

	private $accountKey;

	private $customerid;

	private $isFroxlorVhost;

	private $isLeProduction;

	private $version;

	public function __construct($logger, $version = '1')
	{
		$this->logger = $logger;
		$this->version = $version;
		if (Settings::Get('system.letsencryptca') == 'production') {
			$ca = 'https://acme-v01.api.letsencrypt.org';
		} else {
			$ca = 'https://acme-staging.api.letsencrypt.org';
		}
		$this->client = new Client($ca);
		$this->log("Using '$ca' to generate certificate");
	}

	public function initAccount($certrow, $isFroxlorVhost = false)
	{
		// Let's see if we have the private accountkey
		$this->accountKey = $certrow['leprivatekey'];
		$this->customerId = (!$isFroxlorVhost ? $certrow['customerid'] : null);
		$this->isFroxlorVhost = $isFroxlorVhost;
		$this->isLeProduction = (Settings::Get('system.letsencryptca') == 'production');

		$leregistered=$certrow['leregistered'];

		if (! $this->accountKey || $this->accountKey == 'unset' || !$this->isLeProduction) {

			// generate and save new private key for account
			// ---------------------------------------------

			$this->log('Creating new account key');
			$keys = $this->generateKey();
			// Only store the accountkey in production, in staging always generate a new key
			if ($this->isLeProduction) {
				if ($isFroxlorVhost) {
					Settings::Set('system.lepublickey', $keys['public']);
					Settings::Set('system.leprivatekey', $keys['private']);
					Settings::Set('system.leregistered', 0); // key is not registered
				} else {
					$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `lepublickey` = :public, `leprivatekey` = :private, `leregistered` = :registered WHERE `customerid` = :customerid;");
					Database::pexecute($upd_stmt, array(
						'public' => $keys['public'],
						'private' => $keys['private'],
						'registered' => 0,
						'customerid' => $this->customerId
					));
				}
			}
			$leregistered=0;
			$this->accountKey = $keys['private'];
		} else {
			$this->log('Using existing account key');
		}

		if ($leregistered==0) { // Account not registered

			$this->log('Starting new account registration');
			$response = $this->postNewReg();
			if ($this->client->getLastCode() == 409) {
				$this->log('The key was already registered. Using existing account.');
			} else if ($this->client->getLastCode() == 201) {
				$this->log('New account registered.');
			} else {
				throw new \RuntimeException("Account not initialized, probably due to rate limiting. Whole response: " . json_encode($response));
			}
			$accountUrl=$this->client->getLastLocation();

			$leregistered = 1;
			$this->setLeRegisteredState($leregistered); // Account registered
			$this->log('Lets encrypt Terms of Service accepted');
		}

	}

	/**
	 *
	 * @param array $domains
	 * @param string $domainkey
	 * @param string $csr
	 *        	optional, same behavior as $reuseCsr from the original class, but we're passing the content of the csr already
	 *
	 * @throws \RuntimeException
	 * @return string[]
	 */
	public function signDomains(array $domains, $domainkey = null, $csr = null)
	{
		if (! $this->accountKey) {
			throw new \RuntimeException("Account not initialized");
		}

		$this->log('Starting certificate generation process for domains');

		$privateAccountKey = openssl_pkey_get_private($this->accountKey);
		$accountKeyDetails = openssl_pkey_get_details($privateAccountKey);

		// start domains authentication
		// ----------------------------

		foreach ($domains as $domain) {

			// 1. getting available authentication options
			// -------------------------------------------

			$this->log("Requesting challenge for $domain");

			$response = $this->signedRequest("/acme/new-authz", array(
				"resource" => "new-authz",
				"identifier" => array(
					"type" => "dns",
					"value" => $domain
				)
			));

			if ($this->client->getLastCode() == 403) {
				$this->log("Got status 403 - setting LE status to unregistered.");
				$this->setLeRegisteredState(0);
				throw new RuntimeException("Got 'unauthorized' response - we need to re-register at next run.  Whole response: " . json_encode($response));
			}

			// if response is not an array but a string, it's most likely a server-error, e.g.
			// <HTML><HEAD><TITLE>Error</TITLE></HEAD><BODY>An error occurred while processing your request.
			// <p>Reference&#32;&#35;179&#46;d8be1402&#46;1458059103&#46;3613c4db</BODY></HTML>
			if (! is_array($response)) {
				throw new RuntimeException("Invalid response from LE for domain $domain. Whole response: " . json_encode($response));
			}

			if (! array_key_exists('challenges', $response)) {
				throw new RuntimeException("No challenges received for $domain. Whole response: " . json_encode($response));
			}

			// choose http-01 challenge only
			$challenge = array_reduce($response['challenges'], function ($v, $w) {
				return $v ? $v : ($w['type'] == 'http-01' ? $w : false);
			});

			if (! $challenge) {
				throw new RuntimeException("HTTP Challenge for $domain is not available. Whole response: " . json_encode($response));
			}

			$this->log("Got challenge token for $domain");
			$location = $this->client->getLastLocation();

			// 2. saving authentication token for web verification
			// ---------------------------------------------------

			$directory = Settings::Get('system.letsencryptchallengepath') . '/.well-known/acme-challenge';
			$tokenPath = $directory . '/' . $challenge['token'];

			if (! file_exists($directory) && ! @mkdir($directory, 0755, true)) {
				throw new \RuntimeException("Couldn't create directory to expose challenge: ${tokenPath}");
			}

			$header = array(
				// need to be in precise order!
				"e" => Base64UrlSafeEncoder::encode($accountKeyDetails["rsa"]["e"]),
				"kty" => "RSA",
				"n" => Base64UrlSafeEncoder::encode($accountKeyDetails["rsa"]["n"])
			);
			$payload = $challenge['token'] . '.' . Base64UrlSafeEncoder::encode(hash('sha256', json_encode($header), true));

			file_put_contents($tokenPath, $payload);
			chmod($tokenPath, 0644);

			// 3. verification process itself
			// -------------------------------

			$uri = "http://${domain}/.well-known/acme-challenge/${challenge['token']}";

			$this->log("Token for $domain saved at $tokenPath and should be available at $uri");

			// simple self check
			if (Settings::Get('system.disable_le_selfcheck') == '0')
			{
				$selfcheckpayload = HttpClient::urlGet($uri, false);
				if ($payload !== trim($selfcheckpayload)) {
					$errmsg = json_encode(error_get_last());
					if ($errmsg != "null") {
						$errmsg = "; PHP error: " . $errmsg;
					} else {
						$errmsg = "";
					}
					$this->logger->logAction(CRON_ACTION, LOG_WARNING, "[Lets Encrypt self-check] Please check $uri - token seems to be not available. This is just a simple self-check, it might be wrong but consider using this information when Let's Encrypt fails to issue a certificate" . $errmsg);
				}
			}

			$this->log("Sending request to challenge");

			// send request to challenge
			$result = $this->signedRequest($challenge['uri'], array(
				"resource" => "challenge",
				"type" => "http-01",
				"keyAuthorization" => $payload,
				"token" => $challenge['token']
			));

			// waiting loop
			// we wait for a maximum of 30 seconds to avoid endless loops
			$count = 0;
			do {
				if (empty($result['status']) || $result['status'] == "invalid") {
					@unlink($tokenPath);
					throw new \RuntimeException("Verification ended with error: " . json_encode($result));
				}
				$ended = ! ($result['status'] === "pending");

				if (! $ended) {
					$this->log("Verification pending, sleeping 1s");
					sleep(1);
					$count ++;
				}

				$result = $this->client->get($location);
			} while (! $ended && $count < 30);

			$this->log("Verification ended with status: ${result['status']}");
			@unlink($tokenPath);
		}

		// requesting certificate
		// ----------------------

		// generate private key for domain if not exist
		if (empty($domainkey) || Settings::Get('system.letsencryptreuseold') == 0) {
			$keys = $this->generateKey();
			$domainkey = $keys['private'];
		}

		// load domain key
		$privateDomainKey = openssl_pkey_get_private($domainkey);

		$this->client->getLastLinks();

		if (empty($csr)) {
			$csr = $this->generateCSR($privateDomainKey, $domains);
		}

		// request certificates creation
		$result = $this->signedRequest("/acme/new-cert", array(
			'resource' => 'new-cert',
			'csr' => $csr
		));
		if ($this->client->getLastCode() !== 201) {
			throw new \RuntimeException("Invalid response code: " . $this->client->getLastCode() . ", " . json_encode($result));
		}
		$location = $this->client->getLastLocation();

		// waiting loop
		$certificates = array();
		while (1) {
			$this->client->getLastLinks();

			$result = $this->client->get($location);

			if ($this->client->getLastCode() == 202) {

				$this->log("Certificate generation pending, sleeping 1s");
				sleep(1);
			} else
				if ($this->client->getLastCode() == 200) {

					$this->log("Got certificate! YAY!");
					$certificates[] = $this->parsePemFromBody($result);

					foreach ($this->client->getLastLinks() as $link) {
						$this->log("Requesting chained cert at $link");
						$result = $this->client->get($link);
						$certificates[] = $this->parsePemFromBody($result);
					}

					break;
				} else {

					throw new \RuntimeException("Can't get certificate: HTTP code " . $this->client->getLastCode());
				}
		}

		if (empty($certificates))
			throw new \RuntimeException('No certificates generated');

		$fullchain = implode("\n", $certificates);
		$crt = array_shift($certificates);
		$chain = implode("\n", $certificates);

		$this->log("Done, returning new certificates and key");
		return array(
			'fullchain' => $fullchain,
			'crt' => $crt,
			'chain' => $chain,
			'key' => $domainkey,
			'csr' => $csr
		);
	}

	private function setLeRegisteredState($state)
	{
		if ($this->isLeProduction) {
			if ($this->isFroxlorVhost) {
				Settings::Set('system.leregistered', $state);
			} else {
				$upd_stmt = Database::prepare("UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `leregistered` = :registered WHERE `customerid` = :customerid;");
				Database::pexecute($upd_stmt, array(
					'registered' => $state,
					'customerid' => $this->customerId
				));
			}
		}
	}

	private function parsePemFromBody($body)
	{
		$pem = chunk_split(base64_encode($body), 64, "\n");
		return "-----BEGIN CERTIFICATE-----\n" . $pem . "-----END CERTIFICATE-----\n";
	}

	private function postNewReg()
	{
		$this->log('Getting last terms of service URL');
		$directory = $this->client->get('/directory');
		if (!isset($directory['meta']) || !isset($directory['meta']['terms-of-service'])) {
			throw new \RuntimeException("No terms of service link available!");
		}
		$this->log('Sending registration to letsencrypt server');

		return $this->signedRequest('/acme/new-reg', array(
			'resource' => 'new-reg',
			'agreement' => $directory['meta']['terms-of-service']
		));
	}

	private function generateCSR($privateKey, array $domains)
	{
		$domain = reset($domains);
		$san = implode(",", array_map(function ($dns) {
			return "DNS:" . $dns;
		}, $domains));
		$tmpConf = tmpfile();
		$tmpConfMeta = stream_get_meta_data($tmpConf);
		$tmpConfPath = $tmpConfMeta["uri"];

		// workaround to get SAN working
		fwrite($tmpConf, 'HOME = .
RANDFILE = $ENV::HOME/.rnd
[ req ]
default_bits = ' . Settings::Get('system.letsencryptkeysize') . '
default_keyfile = privkey.pem
distinguished_name = req_distinguished_name
req_extensions = v3_req
[ req_distinguished_name ]
countryName = Country Name (2 letter code)
[ v3_req ]
basicConstraints = CA:FALSE
subjectAltName = ' . $san . '
keyUsage = nonRepudiation, digitalSignature, keyEncipherment');

		$csr = openssl_csr_new(array(
			"CN" => $domain,
			"ST" => Settings::Get('system.letsencryptstate'),
			"C" => Settings::Get('system.letsencryptcountrycode'),
			"O" => "Unknown"
		), $privateKey, array(
			"config" => $tmpConfPath,
			"digest_alg" => "sha256"
		));

		if (! $csr)
			throw new \RuntimeException("CSR couldn't be generated! " . openssl_error_string());

		openssl_csr_export($csr, $csr);
		fclose($tmpConf);

		preg_match('~REQUEST-----(.*)-----END~s', $csr, $matches);

		return trim(Base64UrlSafeEncoder::encode(base64_decode($matches[1])));
	}

	private function generateKey()
	{
		$res = openssl_pkey_new(array(
			"private_key_type" => OPENSSL_KEYTYPE_RSA,
			"private_key_bits" => (int) Settings::Get('system.letsencryptkeysize')
		));

		if (! openssl_pkey_export($res, $privateKey)) {
			throw new \RuntimeException("Key export failed!");
		}

		$details = openssl_pkey_get_details($res);

		return array(
			'private' => $privateKey,
			'public' => $details['key']
		);
	}

	private function signedRequest($uri, array $payload)
	{
		$privateKey = openssl_pkey_get_private($this->accountKey);
		$details = openssl_pkey_get_details($privateKey);

		$header = array(
			"alg" => "RS256",
			"jwk" => array(
				"kty" => "RSA",
				"n" => Base64UrlSafeEncoder::encode($details["rsa"]["n"]),
				"e" => Base64UrlSafeEncoder::encode($details["rsa"]["e"])
			)
		);

		$protected = $header;
		$protected["nonce"] = $this->client->getLastNonce();

		$payload64 = Base64UrlSafeEncoder::encode(str_replace('\\/', '/', json_encode($payload)));
		$protected64 = Base64UrlSafeEncoder::encode(json_encode($protected));

		openssl_sign($protected64 . '.' . $payload64, $signed, $privateKey, "SHA256");

		$signed64 = Base64UrlSafeEncoder::encode($signed);

		$data = array(
			'header' => $header,
			'protected' => $protected64,
			'payload' => $payload64,
			'signature' => $signed64
		);

		$this->log("Sending signed request to $uri");

		return $this->client->post($uri, json_encode($data));
	}

	protected function log($message)
	{
		$this->logger->logAction(CRON_ACTION, LOG_INFO, "letsencrypt " . $message);
	}
}

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

class Base64UrlSafeEncoder
{

	public static function encode($input)
	{
		return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
	}

	public static function decode($input)
	{
		$remainder = strlen($input) % 4;
		if ($remainder) {
			$padlen = 4 - $remainder;
			$input .= str_repeat('=', $padlen);
		}
		return base64_decode(strtr($input, '-_', '+/'));
	}
}
