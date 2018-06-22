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

}
