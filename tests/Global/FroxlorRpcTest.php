<?php
use PHPUnit\Framework\TestCase;

use Froxlor\Database\Database;
use Froxlor\Api\FroxlorRPC;

/**
 *
 * @covers \Froxlor\Api\FroxlorRPC
 */
class FroxlorRpcTest extends TestCase
{

	public function testNoCredentialsGiven()
	{
		$this->expectExceptionCode(401);
		$this->expectExceptionMessage("Unauthenticated. Please provide api user credentials.");
		FroxlorRPC::validateRequest("");
	}

	public function testValidateAuthInvalid()
	{
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Invalid authorization credentials");
		$_SERVER['PHP_AUTH_USER'] = 'asd';
		$_SERVER['PHP_AUTH_PW'] = 'asd';
		FroxlorRPC::validateRequest("");
	}

	public function testValidateAuthAllowFromInvalid()
	{
		$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
		Database::query("UPDATE `api_keys` SET `allowed_from` = '123.123.123.123';");
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Invalid authorization credentials");
		$_SERVER['PHP_AUTH_USER'] = 'test';
		$_SERVER['PHP_AUTH_PW'] = 'test';
		FroxlorRPC::validateRequest("");
	}

	public function testEmptyRequestBody()
	{
		Database::query("UPDATE `api_keys` SET `allowed_from` = '';");
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("Empty request body.");
		$_SERVER['PHP_AUTH_USER'] = 'test';
		$_SERVER['PHP_AUTH_PW'] = 'test';
		FroxlorRPC::validateRequest("");
	}

	public function testInvalidJSON()
	{
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("Invalid JSON Format.");
		$_SERVER['PHP_AUTH_USER'] = 'test';
		$_SERVER['PHP_AUTH_PW'] = 'test';
		FroxlorRPC::validateRequest('asd');
	}

	public function testNoCommandGiven()
	{
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("Please provide a command.");
		$_SERVER['PHP_AUTH_USER'] = 'test';
		$_SERVER['PHP_AUTH_PW'] = 'test';
		FroxlorRPC::validateRequest(json_encode(['cmd' => 'test']));
	}

	public function testInvalidCommandGiven()
	{
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("The given command is invalid.");
		$_SERVER['PHP_AUTH_USER'] = 'test';
		$_SERVER['PHP_AUTH_PW'] = 'test';
		FroxlorRPC::validateRequest(json_encode(['command' => 'Froxlor']));
	}

	public function testUnknownCommandGiven()
	{
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("Unknown command");
		$_SERVER['PHP_AUTH_USER'] = 'test';
		$_SERVER['PHP_AUTH_PW'] = 'test';
		FroxlorRPC::validateRequest(json_encode(['command' => 'SomeModule.cmd']));
	}

	public function testCommandOk()
	{
		$_SERVER['PHP_AUTH_USER'] = 'test';
		$_SERVER['PHP_AUTH_PW'] = 'test';
		$result = FroxlorRPC::validateRequest(json_encode(['command' => 'Froxlor.listFunctions']));
		$this->assertEquals('Froxlor', $result['command']['class']);
		$this->assertEquals('listFunctions', $result['command']['method']);
		$this->assertNull($result['params']);
	}

	public function testApiPhpEscaping()
	{
		$key = $this->generateKey();
		$request = array(
			'command' => 'Froxlor.listFunctions',
			'params' => $key
		);
		$json_request = json_encode($request);
		$decoded_request = json_decode($json_request, true);
		$decoded_request = $this->stripcslashes_deep($decoded_request);
		$this->assertEquals($key['key'], $decoded_request['params']['key']);
		$this->assertEquals($key['cert'], $decoded_request['params']['cert']);
	}

	private function stripcslashes_deep($value)
	{
		return is_array($value) ? array_map([$this, 'stripcslashes_deep'], $value) : stripcslashes($value);
	}

	private function generateKey()
	{
		$dn = array(
			"countryName" => "DE",
			"stateOrProvinceName" => "Hessen",
			"localityName" => "Frankfurt",
			"organizationName" => "Froxlor",
			"organizationalUnitName" => "Testing",
			"commonName" => "test2.local",
			"emailAddress" => "team@froxlor.org"
		);

		// generate key pair
		$privkey = openssl_pkey_new(array(
			"private_key_bits" => 2048,
			"private_key_type" => OPENSSL_KEYTYPE_RSA
		));

		// generate csr
		$csr = openssl_csr_new($dn, $privkey, array(
			'digest_alg' => 'sha256'
		));

		// generate self-signed certificate
		$sscert = openssl_csr_sign($csr, null, $privkey, 365, array(
			'digest_alg' => 'sha256'
		));

		// export
		openssl_x509_export($sscert, $certout);
		openssl_pkey_export($privkey, $pkeyout, null);

		return array(
			'cert' => $certout,
			'key' => $pkeyout
		);
	}
}
