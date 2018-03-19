<?php
use PHPUnit\Framework\TestCase;

/**
 * @covers ApiCommand
 * @covers ApiParameter
 * @covers DirProtections
 */
class DirProtectionsTest extends TestCase
{

	public function testCustomerDirProtectionsAdd()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'path' => '/test',
			'username' => 'testing',
			'directory_password' => generatePassword(),
			'directory_authname' => 'test1'
		];
		$json_result = DirProtections::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals($customer_userdata['documentroot'] . 'test/', $result['path']);
		$this->assertEquals('test1', $result['authname']);
	}
	
	public function testCustomerDirProtectionsAddSameUserPath()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'path' => '/test',
			'username' => 'testing',
			'directory_password' => generatePassword(),
			'directory_authname' => 'test2'
		];
		$this->expectExceptionMessage("Combination of username and path already exists");
		DirProtections::getLocal($customer_userdata, $data)->add();
	}
	
	public function testCustomerDirProtectionsAddPasswordEqualsUsername()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$up = generatePassword();
		$data = [
			'path' => '/test',
			'username' => $up,
			'directory_password' => $up,
			'directory_authname' => 'test3'
		];
		$this->expectExceptionMessage("The password should not be the same as the username.");
		DirProtections::getLocal($customer_userdata, $data)->add();
	}
	
	/**
	 * @depends testCustomerDirProtectionsAdd
	 */
	public function testAdminDirProtectionsGet()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$data = [
			'username' => 'testing',
			'customerid' => 1
		];
		$json_result = DirProtections::getLocal($admin_userdata, $data)->get();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals($customer_userdata['documentroot'] . 'test/', $result['path']);
		$this->assertEquals('test1', $result['authname']);
	}
	
	/**
	 * @depends testCustomerDirProtectionsAdd
	 */
	public function testResellerDirProtectionsGet()
	{
		global $admin_userdata;
		// get reseller
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$data = [
			'username' => 'testing'
		];
		$json_result = DirProtections::getLocal($reseller_userdata, $data)->get();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals($customer_userdata['documentroot'] . 'test/', $result['path']);
		$this->assertEquals('test1', $result['authname']);
	}
	
	/**
	 * @depends testCustomerDirProtectionsAdd
	 */
	public function testCustomerDirProtectionsUpdate()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$json_result = DirProtections::getLocal($customer_userdata, array('id' => 1))->get();
		$data_old = json_decode($json_result, true)['data'];

		$data = [
			'id' => 1,
			'directory_password' => generatePassword(),
			'directory_authname' => 'test1337'
		];
		$json_result = DirProtections::getLocal($customer_userdata, $data)->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue($data_old['password'] != $result['password']);
		$this->assertTrue($data_old['authname'] != $result['authname']);
		$this->assertEquals('test1337', $result['authname']);
	}
	
	/**
	 * @depends testCustomerDirProtectionsAdd
	 */
	public function testCustomerDirProtectionsList()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$json_result = DirProtections::getLocal($customer_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(2, $result['count']);
		$this->assertEquals('test1', $result['list'][0]['username']);
		$this->assertEquals('testing', $result['list'][1]['username']);
	}
	
	/**
	 * @depends testCustomerDirProtectionsList
	 */
	public function testCustomerDirProtectionsDelete()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		DirProtections::getLocal($customer_userdata, array('username' => 'testing'))->delete();

		$json_result = DirProtections::getLocal($customer_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);
		$this->assertEquals('test1', $result['list'][0]['username']);
	}
}
