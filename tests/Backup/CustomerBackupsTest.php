<?php
use PHPUnit\Framework\TestCase;

use Froxlor\Settings;
use Froxlor\Database\Database;
use Froxlor\Api\Commands\Customers;
use Froxlor\Api\Commands\CustomerBackups;

/**
 *
 * @covers \Froxlor\Api\ApiCommand
 * @covers \Froxlor\Api\ApiParameter
 * @covers \Froxlor\Api\Commands\CustomerBackups
 */
class CustomerBackupsTest extends TestCase
{

	public function testAdminCustomerBackupsNotEnabled()
	{
		global $admin_userdata;

		Settings::Set('system.backupenabled', 0, true);

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(405);
		$this->expectExceptionMessage("You cannot access this resource");
		CustomerBackups::getLocal($customer_userdata)->add();
	}

	/**
	 *
	 * @depends testAdminCustomerBackupsNotEnabled
	 */
	public function testAdminCustomerBackupsExtrasHidden()
	{
		global $admin_userdata;

		Settings::Set('system.backupenabled', 1, true);
		Settings::Set('panel.customer_hide_options', 'extras', true);

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(405);
		$this->expectExceptionMessage("You cannot access this resource");
		CustomerBackups::getLocal($customer_userdata)->add();
	}

	/**
	 *
	 * @depends testAdminCustomerBackupsExtrasHidden
	 */
	public function testAdminCustomerBackupsExtrasBackupHidden()
	{
		global $admin_userdata;

		Settings::Set('panel.customer_hide_options', 'extras.backup', true);

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(405);
		$this->expectExceptionMessage("You cannot access this resource");
		CustomerBackups::getLocal($customer_userdata)->add();
	}

	/**
	 *
	 * @depends testAdminCustomerBackupsExtrasBackupHidden
	 */
	public function testCustomerCustomerBackupsAdd()
	{
		global $admin_userdata;

		Settings::Set('panel.customer_hide_options', '', true);
		Database::query("TRUNCATE TABLE `panel_tasks`;");

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'path' => '/my-backup',
			'backup_dbs' => 2,
			'backup_mail' => 3,
			'backup_web' => 4
		];
		$json_result = CustomerBackups::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals($customer_userdata['documentroot'] . 'my-backup/', $result['destdir']);
		$this->assertEquals('1', $result['backup_dbs']);
		$this->assertEquals('1', $result['backup_mail']);
		$this->assertEquals('1', $result['backup_web']);
	}

	/**
	 *
	 * @depends testCustomerCustomerBackupsAdd
	 */
	public function testCustomerCustomerBackupsAddPathNotDocroot()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'path' => '/'
		];

		$this->expectExceptionCode(400);
		$this->expectExceptionMessage('The folder for backups cannot be your homedir, please chose a folder within your homedir, e.g. /backups');
		$json_result = CustomerBackups::getLocal($customer_userdata, $data)->add();
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
		$this->assertEquals('1', $result['list'][0]['data']['backup_mail']);
		$this->assertEquals('1', $result['list'][0]['data']['backup_web']);

		$json_result = CustomerBackups::getLocal($admin_userdata)->listingCount();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result);
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
