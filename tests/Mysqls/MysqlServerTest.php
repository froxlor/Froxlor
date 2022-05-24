<?php

use PHPUnit\Framework\TestCase;

use Froxlor\Api\Commands\MysqlServer;

/**
 *
 * @covers \Froxlor\Api\ApiCommand
 * @covers \Froxlor\Api\ApiParameter

 * @covers \Froxlor\Api\Commands\MysqlServer
 */
class MysqlServerTest extends TestCase
{

	public function testAdminMysqlServerAdd()
	{
		global $admin_userdata;

		$data = [
			'mysql_host' => '192.168.1.254',
			'privileged_user' => 'froxroot',
			'privileged_password' => 'p4ssw0rd',
			'description' => 'Second mysql-server',
			'test_connection' => false
		];
		$json_result = MysqlServer::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['dbserver']);
	}

	public function testAdminMysqlServerAddInvalidHostOrIP()
	{
		global $admin_userdata;

		$data = [
			'mysql_host' => 'abc123+',
			'privileged_user' => 'someone',
			'privileged_password' => 'something'
		];

		$this->expectExceptionCode(406);
		$this->expectExceptionMessage('Invalid mysql server ip/hostname');
		MysqlServer::getLocal($admin_userdata, $data)->add();
	}

	/**
	 * @depends testAdminMysqlServerAdd
	 */
	public function testAdminMysqlServerDeleteDefault()
	{
		global $admin_userdata;

		$data = [
			'dbserver' => 0
		];

		$this->expectExceptionCode(406);
		$this->expectExceptionMessage('Cannot delete first/default mysql-server');
		MysqlServer::getLocal($admin_userdata, $data)->delete();
	}

	/**
	 * @depends testAdminMysqlServerAdd
	 */
	public function testAdminMysqlServerDeleteUnknown()
	{
		global $admin_userdata;

		$data = [
			'dbserver' => 1337
		];

		$this->expectExceptionCode(404);
		$this->expectExceptionMessage('Mysql server not found');
		MysqlServer::getLocal($admin_userdata, $data)->delete();
	}
}
