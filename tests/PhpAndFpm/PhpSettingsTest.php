<?php
use PHPUnit\Framework\TestCase;

/**
 *
 * @covers ApiCommand
 * @covers ApiParameter
 * @covers PhpSettings
 */
class PhpSettingsText extends TestCase
{
	private static $id = 0;

	public function testAdminPhpSettingsList()
	{
		global $admin_userdata;
		$json_result = PhpSettings::getLocal($admin_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals("Default Config", $result['list'][0]['description']);
		$this->assertEquals("/usr/bin/php-cgi", $result['list'][0]['binary']);
	}

	public function testCustomerPhpSettingsListNotAllowed()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");
		PhpSettings::getLocal($customer_userdata)->listing();
	}

	public function testAdminPhpSettingsAdd()
	{
		global $admin_userdata;
		$data = [
			'description' => 'test php',
			'phpsettings' => 'error_reporting=E_ALL',
			'fpmconfig' => Settings::Get('phpfpm.defaultini')
		];
		$json_result = PhpSettings::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('error_reporting=E_ALL', $result['phpsettings']);
		$this->assertEquals('60s', $result['fpm_reqterm']);
		self::$id = $result['id'];
	}
	
	public function testAdminPhpSettingsGet()
	{
		global $admin_userdata;
		$data = [
			'id' => self::$id
		];
		$json_result = PhpSettings::getLocal($admin_userdata, $data)->get();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('error_reporting=E_ALL', $result['phpsettings']);
		$this->assertEquals('60s', $result['fpm_reqterm']);
	}

	public function testAdminPhpSettingsGetNotFound()
	{
		global $admin_userdata;
		$this->expectExceptionCode(404);
		$this->expectExceptionMessage("php-config with id #999 could not be found");
		PhpSettings::getLocal($admin_userdata, array('id' => 999))->get();
	}
	
	public function testCustomerPhpSettingsGetNotAllowed()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");
		PhpSettings::getLocal($customer_userdata, array('id' => 1))->get();
	}
}
