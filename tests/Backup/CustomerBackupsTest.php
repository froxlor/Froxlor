<?php
use PHPUnit\Framework\TestCase;

/**
 *
 * @covers ApiCommand
 * @covers ApiParameter
 * @covers CustomerBackups
 */
class CustomerBackupsTest extends TestCase
{

	public function testCustomerCustomerBackupsAdd()
	{
		global $admin_userdata;
		
		Database::query("TRUNCATE TABLE `panel_tasks`;");
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'path' => '/my-backup',
			'backup_dbs' => 1,
			'backup_mail' => 2,
			'backup_web' => 1
		];
		$json_result = CustomerBackups::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals($customer_userdata['documentroot'] . 'my-backup/', $result['destdir']);
		$this->assertEquals('1', $result['backup_dbs']);
		$this->assertEquals('0', $result['backup_mail']);
		$this->assertEquals('1', $result['backup_web']);
	}

	public function testAdminCustomerBackupsGet()
	{
		global $admin_userdata;
		$this->expectExceptionCode(303);
		CustomerBackups::getLocal($admin_userdata)->get();
	}

	public function testAdminCustomerBackupsUpdate()
	{
		global $admin_userdata;
		$this->expectExceptionCode(303);
		CustomerBackups::getLocal($admin_userdata)->update();
	}

	/**
	 *
	 * @depends testCustomerCustomerBackupsAdd
	 */
	public function testAdminCustomerBackupsListing()
	{
		global $admin_userdata;
		
		$json_result = CustomerBackups::getLocal($admin_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);
		$this->assertEquals('1', $result['list'][0]['data']['backup_dbs']);
		$this->assertEquals('0', $result['list'][0]['data']['backup_mail']);
		$this->assertEquals('1', $result['list'][0]['data']['backup_web']);
	}

	/**
	 *
	 * @depends testCustomerCustomerBackupsAdd
	 */
	public function testCustomerCustomerBackupsDelete()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'backup_job_entry' => 1
		];
		$json_result = CustomerBackups::getLocal($customer_userdata, $data)->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue($result);
	}

	/**
	 *
	 * @depends testAdminCustomerBackupsListing
	 */
	public function testCustomerCustomerBackupsDeleteNotFound()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'backup_job_entry' => 1337
		];
		$this->expectExceptionCode(404);
		$this->expectExceptionMessage('Backup job with id #1337 could not be found');
		CustomerBackups::getLocal($customer_userdata, $data)->delete();
	}
}
