<?php
use PHPUnit\Framework\TestCase;

/**
 *
 * @covers ApiCommand
 * @covers ApiParameter
 * @covers FpmDaemons
 */
class FpmDaemonsTest extends TestCase
{
	private static $id = 0;

	public function testAdminFpmDaemonsAdd()
	{
		global $admin_userdata;
		$data = [
			'description' => 'test2 fpm',
			'reload_cmd' => 'service php7.1-fpm reload',
			'config_dir' => '/etc/php/7.1/fpm/pool.d'
		];
		$json_result = FpmDaemons::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('/etc/php/7.1/fpm/pool.d/', $result['config_dir']);
		$this->assertEquals(0, $result['max_children']);
		$this->assertEquals('.php', $result['limit_extensions']);
		self::$id = $result['id'];
	}
	
	/**
	 * @depends testAdminFpmDaemonsAdd
	 */
	public function testAdminFpmDaemonsUpdate()
	{
		global $admin_userdata;
		$data = [
			'id' => self::$id,
			'description' => 'test2 fpm edit',
			'pm' => 'dynamic',
			'max_children' => '10',
			'start_servers' => '4',
			'limit_extensions' => '.php .php.xml',
		];
		$json_result = FpmDaemons::getLocal($admin_userdata, $data)->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('/etc/php/7.1/fpm/pool.d/', $result['config_dir']);
		$this->assertEquals(10, $result['max_children']);
		$this->assertEquals('.php .php.xml', $result['limit_extensions']);
	}

	/**
	 * @depends testAdminFpmDaemonsUpdate
	 */
	public function testAdminFpmDaemonsList()
	{
		global $admin_userdata;
		$json_result = FpmDaemons::getLocal($admin_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(2, $result['count']);
		$this->assertEquals('System default', $result['list'][0]['description']);
		$this->assertEquals('test2 fpm edit', $result['list'][1]['description']);
	}

	/**
	 * @depends testAdminFpmDaemonsList
	 */
	public function testAdminFpmDaemonsDelete()
	{
		global $admin_userdata;
		$data = [
			'id' => self::$id
		];
		$json_result = FpmDaemons::getLocal($admin_userdata, $data)->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('/etc/php/7.1/fpm/pool.d/', $result['config_dir']);
		$this->assertEquals(10, $result['max_children']);
		$this->assertEquals('.php .php.xml', $result['limit_extensions']);
	}

	/**
	 * @depends testAdminFpmDaemonsDelete
	 */
	public function testAdminFpmDaemonsDeleteDefaultConfig()
	{
		global $admin_userdata;
		$data = [
			'id' => 1
		];
		$this->expectExceptionMessage("This PHP-configuration is set as default and cannot be deleted.");
		FpmDaemons::getLocal($admin_userdata, $data)->delete();
	}
}
