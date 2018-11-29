<?php
use PHPUnit\Framework\TestCase;

/**
 * @covers FroxlorRPC
 */
class FroxlorRpcTest extends TestCase
{

	public function testInvalidRequestHeader()
	{
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("Invalid request header");
		FroxlorRPC::validateRequest(array());
	}

	public function testNoCredentialsGiven()
	{
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("No authorization credentials given");
		FroxlorRPC::validateRequest(array(
			'header' => 'asd'
		));
	}

	public function testValidateAuthInvalid()
	{
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Invalid authorization credentials");
		FroxlorRPC::validateRequest(array(
			'header' => [
				'apikey' => 'asd',
				'secret' => 'asd'
			]
		));
	}

	public function testValidateAuthAllowFromInvalid()
	{
		$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
		Database::query("UPDATE `api_keys` SET `allowed_from` = '123.123.123.123';");
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Invalid authorization credentials");
		FroxlorRPC::validateRequest(array(
			'header' => [
				'apikey' => 'test',
				'secret' => 'test'
			]
		));
	}

	public function testInvalidRequestBody()
	{
		Database::query("UPDATE `api_keys` SET `allowed_from` = '';");
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("Invalid request body");
		FroxlorRPC::validateRequest(array(
			'header' => [
				'apikey' => 'test',
				'secret' => 'test'
			]
		));
	}

	public function testNoCommandGiven()
	{
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("No command given");
		FroxlorRPC::validateRequest(array(
			'header' => [
				'apikey' => 'test',
				'secret' => 'test'
			],
			'body' => 'asd'
		));
	}

	public function testInvalidCommandGiven()
	{
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("Invalid command");
		FroxlorRPC::validateRequest(array(
			'header' => [
				'apikey' => 'test',
				'secret' => 'test'
			],
			'body' => ['command' => 'Froxlor']
		));
	}

	public function testUnknownCommandGiven()
	{
		$this->expectExceptionCode(400);
		$this->expectExceptionMessage("Unknown command");
		FroxlorRPC::validateRequest(array(
			'header' => [
				'apikey' => 'test',
				'secret' => 'test'
			],
			'body' => ['command' => 'SomeModule.cmd']
		));
	}

	public function testCommandOk()
	{
		$result = FroxlorRPC::validateRequest(array(
			'header' => [
				'apikey' => 'test',
				'secret' => 'test'
			],
			'body' => ['command' => 'Froxlor.listFunctions']
		));
		$this->assertEquals('Froxlor', $result['command']['class']);
		$this->assertEquals('listFunctions', $result['command']['method']);
		$this->assertNull($result['params']);
	}
}
