<?php
use PHPUnit\Framework\TestCase;

use Froxlor\Database\Database;
use Froxlor\Api\Commands\Customers;
use Froxlor\Api\Commands\Traffic;

/**
 *
 * @covers \Froxlor\Api\ApiCommand
 * @covers \Froxlor\Api\ApiParameter
 * @covers \Froxlor\Api\Commands\Traffic
 * @covers \Froxlor\Api\Commands\Customers
 * @covers \Froxlor\Api\Commands\Admins
 */
class TrafficTest extends TestCase
{

	public static function setUpBeforeClass(): void
	{
		$ins_stmt = Database::prepare("
			INSERT INTO `" . TABLE_PANEL_TRAFFIC . "` SET
			`customerid` = :cid,
			`year` = :y, `month` = :m, `day` = :d,
			`stamp` = :ts,
			`http` = :http, `ftp_up` = :fup, `ftp_down` = :fdown, `mail` = :mail
		");

		$ins_adm_stmt = Database::prepare("
			INSERT INTO `" . TABLE_PANEL_TRAFFIC_ADMINS . "` SET
			`adminid` = :aid,
			`year` = :y, `month` = :m, `day` = :d,
			`stamp` = :ts,
			`http` = :http, `ftp_up` = :fup, `ftp_down` = :fdown, `mail` = :mail
		");

		$http = 5 * 1024 * 1024 * 1024; // 5 GB
		$fup = 50 * 1024 * 1024; // 50 MB
		$fdown = 2 * 1024 * 1024 * 1024; // 2 GB
		$mail = 250 * 1024 * 1024; // 250 MB

		foreach (array(
			1,
			2,
			3
		) as $cid) {
			Database::pexecute($ins_stmt, array(
				'cid' => $cid,
				'y' => date('Y'),
				'm' => date('m'),
				'd' => date('d'),
				'ts' => time(),
				'http' => $http,
				'fup' => $fup,
				'fdown' => $fdown,
				'mail' => $mail
			));
		}

		Database::pexecute($ins_adm_stmt, array(
			'aid' => 1,
			'y' => date('Y'),
			'm' => date('m'),
			'd' => date('d'),
			'ts' => time(),
			'http' => $http * 2,
			'fup' => $fup * 2,
			'fdown' => $fdown * 2,
			'mail' => $mail * 2
		));
	}

	public function testAdminTrafficList()
	{
		global $admin_userdata;

		$json_result = Traffic::getLocal($admin_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);
		$http = 2 * (5 * 1024 * 1024 * 1024 * 1024); // 2x 5 GB
		$this->assertEquals($http, $result['list'][0]['http']);

		$this->expectExceptionCode(303);
		$this->expectExceptionMessage("You cannot count the traffic data list");
		Traffic::getLocal($admin_userdata)->listingCount();
	}

	public function testAdminTrafficListSpecificDate()
	{
		global $admin_userdata;

		$json_result = Traffic::getLocal($admin_userdata, array(
			'year' => date('Y') + 1,
			'month' => date('m'),
			'day' => date('d')
		))->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(0, $result['count']);
	}

	public function testAdminTrafficListCustomers()
	{
		global $admin_userdata;

		$json_result = Traffic::getLocal($admin_userdata, array(
			'customer_traffic' => 1
		))->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(2, $result['count']);
		$this->assertEquals(1, $result['list'][0]['customerid']);
		$this->assertEquals(3, $result['list'][1]['customerid']);
	}

	public function testAdminTrafficListCustomersFilterCustomer()
	{
		global $admin_userdata;

		$json_result = Traffic::getLocal($admin_userdata, array(
			'customer_traffic' => 1,
			'loginname' => 'test1'
		))->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);
		$this->assertEquals(1, $result['list'][0]['customerid']);
	}

	public function testCustomerTrafficList()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$json_result = Traffic::getLocal($customer_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);
		$mail = 250 * 1024 * 1024 * 1024; // 250 MB
		$this->assertEquals($mail, $result['list'][0]['mail']);

		$this->expectExceptionCode(303);
		$this->expectExceptionMessage("You cannot count the traffic data list");
		Traffic::getLocal($admin_userdata)->listingCount();
	}

	public function testAdminTrafficAdd()
	{
		global $admin_userdata;

		$this->expectExceptionCode(303);
		$this->expectExceptionMessage("You cannot add traffic data");
		Traffic::getLocal($admin_userdata)->add();
	}

	public function testAdminTrafficGet()
	{
		global $admin_userdata;

		$this->expectExceptionCode(303);
		$this->expectExceptionMessage("To get specific traffic details use year, month and/or day parameter for Traffic.listing()");
		Traffic::getLocal($admin_userdata)->get();
	}

	public function testAdminTrafficUpdate()
	{
		global $admin_userdata;

		$this->expectExceptionCode(303);
		$this->expectExceptionMessage("You cannot update traffic data");
		Traffic::getLocal($admin_userdata)->update();
	}

	public function testAdminTrafficDelete()
	{
		global $admin_userdata;

		$this->expectExceptionCode(303);
		$this->expectExceptionMessage("You cannot delete traffic data");
		Traffic::getLocal($admin_userdata)->delete();
	}
}
