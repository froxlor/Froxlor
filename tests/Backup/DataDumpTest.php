<?php
use PHPUnit\Framework\TestCase;

use Froxlor\Settings;
use Froxlor\Database\Database;
use Froxlor\Api\Commands\Customers;
use Froxlor\Api\Commands\DataDump;

/**
 *
 * @covers \Froxlor\Api\ApiCommand
 * @covers \Froxlor\Api\ApiParameter
 * @covers \Froxlor\Api\Commands\DataDump
 */
class DataDumpTest extends TestCase
{

	public function testAdminDataDumpNotEnabled()
	{
		global $admin_userdata;

		Settings::Set('system.exportenabled', 0, true);

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(405);
		$this->expectExceptionMessage("You cannot access this resource");
		DataDump::getLocal($customer_userdata)->add();
	}

	/**
	 *
	 * @depends testAdminDataDumpNotEnabled
	 */
	public function testAdminDataDumpExtrasHidden()
	{
		global $admin_userdata;

		Settings::Set('system.exportenabled', 1, true);
		Settings::Set('panel.customer_hide_options', 'extras', true);

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(405);
		$this->expectExceptionMessage("You cannot access this resource");
		DataDump::getLocal($customer_userdata)->add();
	}

	/**
	 *
	 * @depends testAdminDataDumpExtrasHidden
	 */
	public function testAdminDataDumpExtrasExportHidden()
	{
		global $admin_userdata;

		Settings::Set('panel.customer_hide_options', 'extras.export', true);

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(405);
		$this->expectExceptionMessage("You cannot access this resource");
		DataDump::getLocal($customer_userdata)->add();
	}

	/**
	 *
	 * @depends testAdminDataDumpExtrasExportHidden
	 */
	public function testCustomerDataDumpAdd()
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
			'path' => '/my-dump',
			'dump_dbs' => 2,
			'dump_mail' => 3,
			'dump_web' => 4
		];
		$json_result = DataDump::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals($customer_userdata['documentroot'] . 'my-dump/', $result['destdir']);
		$this->assertEquals('1', $result['dump_dbs']);
		$this->assertEquals('1', $result['dump_mail']);
		$this->assertEquals('1', $result['dump_web']);
	}

	/**
	 *
	 * @depends testCustomerDataDumpAdd
	 */
	public function testCustomerDataDumpAddPathNotDocroot()
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
		$this->expectExceptionMessage('The folder for data-dumps cannot be your homedir, please chose a folder within your homedir, e.g. /dumps');
		$json_result = DataDump::getLocal($customer_userdata, $data)->add();
	}

	public function testAdminDataDumpGet()
	{
		global $admin_userdata;
		$this->expectExceptionCode(303);
		DataDump::getLocal($admin_userdata)->get();
	}

	public function testAdminDataDumpUpdate()
	{
		global $admin_userdata;
		$this->expectExceptionCode(303);
		DataDump::getLocal($admin_userdata)->update();
	}

	/**
	 *
	 * @depends testCustomerDataDumpAdd
	 */
	public function testAdminDataDumpListing()
	{
		global $admin_userdata;

		$json_result = DataDump::getLocal($admin_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);
		$this->assertEquals('1', $result['list'][0]['data']['dump_dbs']);
		$this->assertEquals('1', $result['list'][0]['data']['dump_mail']);
		$this->assertEquals('1', $result['list'][0]['data']['dump_web']);

		$json_result = DataDump::getLocal($admin_userdata)->listingCount();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result);
	}

	/**
	 *
	 * @depends testCustomerDataDumpAdd
	 */
	public function testCustomerDataDumpDelete()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'job_entry' => 1
		];
		$json_result = DataDump::getLocal($customer_userdata, $data)->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue($result);
	}

	/**
	 *
	 * @depends testAdminDataDumpListing
	 */
	public function testCustomerDataDumpDeleteNotFound()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'job_entry' => 1337
		];
		$this->expectExceptionCode(404);
		$this->expectExceptionMessage('Data export job with id #1337 could not be found');
		DataDump::getLocal($customer_userdata, $data)->delete();
	}
}
