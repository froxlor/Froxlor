<?php
use PHPUnit\Framework\TestCase;

/**
 * @covers ApiCommand
 * @covers Ftps
 */
class FtpsTest extends TestCase
{

	public function testAdminFtpsGetId()
	{
		global $admin_userdata;

		$json_result = Ftps::getLocal($admin_userdata, array(
			'id' => 1
		))->get();
		$result = json_decode($json_result, true)['data'];
		
		// should be the ftp user of the first added customr 'test1'
		$this->assertEquals('test1', $result['username']);
	}

	public function testCustomerFtpsGetId()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'id' => 1
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$json_result = Ftps::getLocal($customer_userdata, array(
			'id' => 1
		))->get();
		$result = json_decode($json_result, true)['data'];
		
		// should be the ftp user of the first added customr 'test1'
		$this->assertEquals('test1', $result['username']);
	}
	
	public function testCustomerFtpsGetOtherId()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'id' => 1
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$this->expectExceptionCode(404);

		Ftps::getLocal($customer_userdata, array(
			'id' => 10
		))->get();
	}
	
	public function testAdminFtpsList()
	{
		global $admin_userdata;
		
		$json_result = Ftps::getLocal($admin_userdata)->list();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);
	}

	public function testAdminFtpsListSpecificCustomer()
	{
		global $admin_userdata;
		
		$json_result = Ftps::getLocal($admin_userdata, array('loginname' => 'test1'))->list();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);
		$this->assertEquals('test1', $result['list'][0]['username']);
	}
	
	public function testResellerFtpsList()
	{
		global $admin_userdata;
		// get reseller
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		$json_result = Ftps::getLocal($reseller_userdata)->list();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);
		$this->assertEquals('test1', $result['list'][0]['username']);
	}
	
	public function testCustomerFtpsList()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$json_result = Ftps::getLocal($customer_userdata)->list();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);
		$this->assertEquals('test1', $result['list'][0]['username']);
	}
}
