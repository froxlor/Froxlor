<?php
use PHPUnit\Framework\TestCase;

/**
 * @covers ApiCommand
 * @covers ApiParameter
 * @covers IpsAndPorts
 */
class IpsAndPortsTest extends TestCase
{

	public function testAdminIpsAndPortsList()
	{
		global $admin_userdata;
		$json_result = IpsAndPorts::getLocal($admin_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(2, $result['count']);
		$this->assertEquals('82.149.225.46', $result['list'][0]['ip']);
	}

	public function testResellerIpsAndPortsListHasNone()
	{
		global $admin_userdata;
		// update reseller to allow no ip access
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller',
			'ipaddress' => array()
		))->update();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");
		$json_result = IpsAndPorts::getLocal($reseller_userdata)->listing();
	}

	public function testAdminIpsAndPortsAdd()
	{
		global $admin_userdata;
		$data = [
			'ip' => '82.149.225.47'
		];
		$json_result = IpsAndPorts::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(3, $result['id']);
		$this->assertEquals(80, $result['port']);
	}
	
	/**
	 * @depends testAdminIpsAndPortsAdd
	 */
	public function testAdminIpsAndPortsAddExists()
	{
		global $admin_userdata;
		$this->expectExceptionMessage("This IP/Port combination already exists.");
		$data = [
			'ip' => '82.149.225.47'
		];
		IpsAndPorts::getLocal($admin_userdata, $data)->add();
	}
	
	public function testAdminIpsAndPortsAddIpv6()
	{
		global $admin_userdata;
		$data = [
			'ip' => '2a01:440:1:12:82:149:225:46',
			'docroot' => '/var/www/html'
		];
		$json_result = IpsAndPorts::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(4, $result['id']);
		$this->assertEquals('/var/www/html/', $result['docroot']);
	}
	
	public function testAdminIpsAndPortsGetNotFound()
	{
		global $admin_userdata;
		$this->expectExceptionCode(404);
		$this->expectExceptionMessage("IP/port with id #999 could not be found");
		IpsAndPorts::getLocal($admin_userdata, array('id' => 999))->get();
	}
	
	/**
	 * @depends testAdminIpsAndPortsAdd
	 */
	public function testResellerIpsAndPortsList()
	{
		global $admin_userdata;
		// update reseller to allow ip access to ip id #3
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller',
			'ipaddress' => array(3)
		))->update();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		$json_result = IpsAndPorts::getLocal($reseller_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);
		$this->assertEquals('82.149.225.47', $result['list'][0]['ip']);
	}
	
	/**
	 * @depends testResellerIpsAndPortsList
	 */
	public function testResellerIpsAndPortsGet()
	{
		global $admin_userdata;
		// update reseller to allow ip access to ip id #2
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		$json_result = IpsAndPorts::getLocal($reseller_userdata, array('id' => 3))->get();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('82.149.225.47', $result['ip']);
	}
	
	/**
	 * @depends testResellerIpsAndPortsList
	 */
	public function testResellerIpsAndPortsGetRestrictedNotOwned()
	{
		global $admin_userdata;
		// get reseller
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		$this->expectExceptionCode(405);
		$this->expectExceptionMessage("You cannot access this resource");
		IpsAndPorts::getLocal($reseller_userdata, array('id' => 1))->get();
	}
	
	public function testResellerIpsAndPortsAdd()
	{
		global $admin_userdata;
		// get reseller
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");
		$data = [
			'ip' => '82.149.225.48'
		];
		IpsAndPorts::getLocal($reseller_userdata, $data)->add();
	}

	public function testCustomerIpsAndPortsGetNotAllowed()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");
		IpsAndPorts::getLocal($customer_userdata, array('id' => 1))->get();
	}
	
	public function testAdminIpsAndPortsEdit()
	{
		global $admin_userdata;
		$data = [
			'id' => 1,
			'listen_statement' => 1,
			'docroot' => '/var/www/html'
		];
		$json_result = IpsAndPorts::getLocal($admin_userdata, $data)->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['listen_statement']);
		$this->assertEquals('/var/www/html/', $result['docroot']);
	}

	public function testResellerIpsAndPortsEditNotAllowed()
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
			'listen_statement' => 0
		];
		$this->expectExceptionCode(405);
		$this->expectExceptionMessage("You cannot access this resource");
		IpsAndPorts::getLocal($reseller_userdata, $data)->update();
	}

	public function testCustomerIpsAndPortsEditNotAllowed()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$data = [
			'id' => 1,
			'listen_statement' => 0
		];
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");
		IpsAndPorts::getLocal($customer_userdata, $data)->update();
	}

	public function testAdminIpsAndPortsEditCantChangeSystemIp()
	{
		global $admin_userdata;
		$data = [
			'id' => 1,
			'ip' => '123.123.123.123'
		];
		$this->expectExceptionMessage("You cannot change the last system IP, either create another new IP/Port combination for the system IP or change the system IP.");
		$json_result = IpsAndPorts::getLocal($admin_userdata, $data)->update();
	}
	
	public function testResellerIpsAndPortsEditNoDuplicate()
	{
		global $admin_userdata;
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		$data = [
			'id' => 3,
			'ip' => '82.149.225.46'
		];
		$this->expectExceptionMessage("This IP/Port combination already exists.");
		IpsAndPorts::getLocal($reseller_userdata, $data)->update();
	}
	
	public function testAdminIpsAndPortsDeleteCantDeleteDefaultIp()
	{
		global $admin_userdata;
		$data = [
			'id' => 1
		];
		$this->expectExceptionMessage("You cannot delete the default IP/Port combination, please make another IP/Port combination default for before deleting this IP/Port combination.");
		IpsAndPorts::getLocal($admin_userdata, $data)->delete();
	}
	
	public function testAdminIpsAndPortsDelete()
	{
		global $admin_userdata;
		$data = [
			'id' => 3
		];
		$json_result = IpsAndPorts::getLocal($admin_userdata, $data)->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('82.149.225.47', $result['ip']);
	}
	
	public function testResellerIpsAndPortsDeleteNotAllowed()
	{
		global $admin_userdata;
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		$data = [
			'id' => 1
		];
		$this->expectExceptionCode(403);
		$this->expectExceptionMessage("Not allowed to execute given command.");
		IpsAndPorts::getLocal($reseller_userdata, $data)->delete();
	}
}
