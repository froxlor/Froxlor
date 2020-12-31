<?php
use PHPUnit\Framework\TestCase;

use Froxlor\Api\Commands\Admins;
use Froxlor\Api\Commands\Customers;
use Froxlor\Api\Commands\Cronjobs;

/**
 *
 * @covers \Froxlor\Api\ApiCommand
 * @covers \Froxlor\Api\ApiParameter
 * @covers \Froxlor\Api\Commands\Cronjobs
 */
class CronjobsTest extends TestCase
{

	public function testAdminCronjobsList()
	{
		global $admin_userdata;
		$json_result = Cronjobs::getLocal($admin_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue(isset($result['list'][0]['module']));
		$this->assertTrue(isset($result['list'][0]['cronfile']));

		$json_result = Cronjobs::getLocal($admin_userdata)->listingCount();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(6, $result);
	}

	public function testCustomerCronjobsListNotAllowed()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");
		Cronjobs::getLocal($customer_userdata)->listing();
	}

	public function testAdminCronjobsAdd()
	{
		global $admin_userdata;
		$data = [];
		$this->expectExceptionCode(303);
		$this->expectExceptionMessage("You cannot add new cronjobs yet.");
		Cronjobs::getLocal($admin_userdata, $data)->add();
	}

	public function testAdminCronjobsGetNotFound()
	{
		global $admin_userdata;
		$this->expectExceptionCode(404);
		$this->expectExceptionMessage("cronjob with id #999 could not be found");
		Cronjobs::getLocal($admin_userdata, array(
			'id' => 999
		))->get();
	}

	public function testCustomerCronjobsGetNotAllowed()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");
		Cronjobs::getLocal($customer_userdata, array(
			'id' => 1
		))->get();
	}

	public function testAdminCronjobsEdit()
	{
		global $admin_userdata;
		$data = [
			'id' => 1,
			'isactive' => 0,
			'interval_value' => 10
		];
		$json_result = Cronjobs::getLocal($admin_userdata, $data)->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(0, $result['isactive']);
		$this->assertEquals('10 MINUTE', $result['interval']);
	}

	public function testResellerCronjobsEditNotAllowed()
	{
		global $admin_userdata;
		// get reseller
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		$data = [
			'id' => 1,
			'isactive' => 1
		];
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");
		Cronjobs::getLocal($reseller_userdata, $data)->update();
	}

	public function testAdminCronjobsDelete()
	{
		global $admin_userdata;
		$data = [
			'id' => 3
		];
		$this->expectExceptionCode(303);
		$this->expectExceptionMessage("You cannot delete system cronjobs.");
		Cronjobs::getLocal($admin_userdata, $data)->delete();
	}
}
