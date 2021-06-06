<?php
use PHPUnit\Framework\TestCase;

use Froxlor\Settings;
use Froxlor\Database\Database;
use Froxlor\Api\Commands\Admins;
use Froxlor\Api\Commands\Customers;
use Froxlor\Api\Commands\HostingPlans;

/**
 *
 * @covers \Froxlor\Api\ApiCommand
 * @covers \Froxlor\Api\ApiParameter
 * @covers \Froxlor\Api\Commands\HostingPlans
 * @covers \Froxlor\Api\Commands\Customers
 */
class HostingPlansTest extends TestCase
{

	public function testAdminPlanAdd()
	{
		global $admin_userdata;

		$data = [
			'name' => 'test',
			'description' => 'first test plan',
			'diskspace' => 0,
			'diskspace_ul' => 1,
			'traffic' => - 1,
			'subdomains' => 15,
			'emails' => - 1,
			'email_accounts' => 15,
			'email_forwarders' => 15,
			'email_imap' => 1,
			'email_pop3' => 0,
			'ftps' => 15,
			'mysqls' => 15,
			'phpenabled' => 1,
			'dnsenabled' => 1,
			'allowed_phpconfigs' => array(
				1
			)
		];

		$json_result = HostingPlans::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$result['value'] = json_decode($result['value'], true);
		foreach ($result['value'] as $index => $value) {
			$result[$index] = $value;
		}
		$this->assertEquals('test', $result['name']);
		$this->assertEquals(- 1, $result['diskspace']);
		$this->assertEquals(15, $result['email_accounts']);
		$this->assertEquals([
			1
		], $result['allowed_phpconfigs']);
	}

	public function testAdminPlanAddEmptyName()
	{
		global $admin_userdata;

		$data = [
			'description' => 'test plan'
		];

		$this->expectExceptionMessage('Requested parameter "name" could not be found for "HostingPlans:add"');
		HostingPlans::getLocal($admin_userdata, $data)->add();

		$data['name'] = null;
		$this->expectExceptionMessage('Requested parameter "name" is empty where it should not be for "HostingPlans:add"');
		HostingPlans::getLocal($admin_userdata, $data)->add();
	}

	/**
	 *
	 * @depends testAdminPlanAdd
	 */
	public function testAdminPlanList()
	{
		global $admin_userdata;

		$json_result = HostingPlans::getLocal($admin_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);

		$json_result = HostingPlans::getLocal($admin_userdata)->listingCount();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result);
	}

	/**
	 *
	 * @depends testAdminPlanAdd
	 */
	public function testResellerPlanList()
	{
		global $admin_userdata;
		// get reseller
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		$json_result = HostingPlans::getLocal($reseller_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(0, $result['count']);

		$json_result = HostingPlans::getLocal($reseller_userdata)->listingCount();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(0, $result);
	}

	/**
	 *
	 * @depends testAdminPlanAdd
	 */
	public function testCustomerPlanList()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'id' => 1
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");
		$json_result = HostingPlans::getLocal($customer_userdata)->listing();

		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");
		$json_result = HostingPlans::getLocal($customer_userdata)->listingCount();
	}

	public function testCustomerPlanAdd()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'id' => 1
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");

		$json_result = HostingPlans::getLocal($customer_userdata)->add();
	}

	public function testCustomerPlanGet()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'id' => 1
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");

		$json_result = HostingPlans::getLocal($customer_userdata)->get();
	}

	public function testCustomerPlanUpdate()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'id' => 1
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");

		$json_result = HostingPlans::getLocal($customer_userdata)->update();
	}

	public function testCustomerPlanDelete()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'id' => 1
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");

		$json_result = HostingPlans::getLocal($customer_userdata)->delete();
	}

	public function testAdminPlanGetNotFound()
	{
		global $admin_userdata;
		$this->expectExceptionCode(404);
		$this->expectExceptionMessage("Hosting-plan with id #999 could not be found");
		HostingPlans::getLocal($admin_userdata, array(
			'id' => 999
		))->get();
	}

	/**
	 *
	 * @depends testAdminPlanAdd
	 */
	public function testAdminPlanUpdate()
	{
		global $admin_userdata;

		HostingPlans::getLocal($admin_userdata, array(
			'planname' => 'test',
			'name' => '',
			'ftps' => '20'
		))->update();

		$json_result = HostingPlans::getLocal($admin_userdata, array(
			'planname' => 'test'
		))->get();
		$result = json_decode($json_result, true)['data'];
		$result['value'] = json_decode($result['value'], true);
		foreach ($result['value'] as $index => $value) {
			$result[$index] = $value;
		}
		$this->assertEquals(20, $result['ftps']);
		$this->assertEquals(- 1, $result['diskspace']);
		$this->assertEquals(15, $result['email_accounts']);
		$this->assertEquals([
			1
		], $result['allowed_phpconfigs']);
	}

	public function testResellerPlanDeleteNotOwned()
	{
		global $admin_userdata;
		// get reseller
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		$this->expectExceptionCode(404);
		HostingPlans::getLocal($reseller_userdata, array(
			'planname' => 'test'
		))->delete();
	}

	/**
	 *
	 * @depends testAdminPlanAdd
	 */
	public function testAdminPlanDelete()
	{
		global $admin_userdata;
		// add new customer
		$data = [
			'name' => 'test2',
			'description' => 'second test plan'
		];
		HostingPlans::getLocal($admin_userdata, $data)->add();
		$json_result = HostingPlans::getLocal($admin_userdata, array(
			'planname' => 'test2'
		))->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('test2', $result['name']);
	}

	/**
	 *
	 * @depends testAdminPlanAdd
	 */
	public function testAdminCustomersAddWithHostingPlan()
	{
		global $admin_userdata;

		$json_result = HostingPlans::getLocal($admin_userdata, array(
			'planname' => 'test'
		))->get();
		$result = json_decode($json_result, true)['data'];

		$data = [
			'new_loginname' => 'test1hp',
			'email' => 'team@froxlor.org',
			'firstname' => 'Test',
			'name' => 'Testman',
			'customernumber' => 1337,
			'createstdsubdomain' => 0,
			'new_customer_password' => 'h0lYmo1y',
			'sendpassword' => TRAVIS_CI == 1 ? 0 : 1,
			'store_defaultindex' => 1,
			'custom_notes' => 'secret',
			'custom_notes_show' => 0,
			'gender' => 5,
			'hosting_plan_id' => $result['id']
		];

		$json_result = Customers::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(- 1024, $result['diskspace']);
		$this->assertEquals(15, $result['subdomains']);
		$this->assertEquals(1, $result['phpenabled']);
		$this->assertJsonStringEqualsJsonString(json_encode([
			1
		]), $result['allowed_phpconfigs']);

		// remove customer
		Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1hp'
		))->delete();
	}
}
