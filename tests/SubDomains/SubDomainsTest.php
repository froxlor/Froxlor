<?php
use PHPUnit\Framework\TestCase;

/**
 * @covers ApiCommand
 * @covers ApiParameter
 * @covers SubDomains
 * @covers Domains
 * @covers Customers
 * @covers Admins
 */
class SubDomainsTest extends TestCase
{

	public function testCustomerSubDomainsAdd()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'subdomain' => 'mysub',
			'domain' => 'test2.local'
		];
		$json_result = SubDomains::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('mysub.test2.local', $result['domain']);
	}

	public function testResellerSubDomainsAdd()
	{
		global $admin_userdata;
		// get reseller
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		
		$data = [
			'subdomain' => 'mysub2',
			'domain' => 'test2.local',
			'customerid' => 1
		];
		$json_result = SubDomains::getLocal($reseller_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('mysub2.test2.local', $result['domain']);
	}

	public function testCustomerSubDomainsAddNoPunycode()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'subdomain' => 'xn--asd',
			'domain' => 'unknown.froxlor.org'
		];
		$this->expectExceptionMessage('You must not specify punycode (IDNA). The domain will automatically be converted');
		SubDomains::getLocal($customer_userdata, $data)->add();
	}

	public function testCustomerSubDomainsAddMainDomainUnknown()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'subdomain' => 'wohoo',
			'domain' => 'unknown.froxlor.org'
		];
		$this->expectExceptionMessage('The main-domain unknown.froxlor.org does not exist.');
		SubDomains::getLocal($customer_userdata, $data)->add();
	}

	public function testCustomerSubDomainsAddInvalidDomain()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'subdomain' => '#+?',
			'domain' => 'unknown.froxlor.org'
		];
		$this->expectExceptionMessage("Wrong Input in Field 'Domain'");
		SubDomains::getLocal($customer_userdata, $data)->add();
	}

	/**
	 * @depends testCustomerSubDomainsAdd
	 */
	public function testAdminSubDomainsGet()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'domainname' => 'mysub.test2.local'
		];
		$json_result = SubDomains::getLocal($admin_userdata, $data)->get();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('mysub.test2.local', $result['domain']);
		$this->assertEquals(1, $result['customerid']);
	}

	/**
	 * @depends testCustomerSubDomainsAdd
	 */
	public function testAdminSubDomainsGetMainDomain()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'domainname' => 'test2.local'
		];
		$json_result = SubDomains::getLocal($admin_userdata, $data)->get();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('test2.local', $result['domain']);
		$this->assertEquals(1, $result['customerid']);
	}

	/**
	 * @depends testCustomerSubDomainsAdd
	 */
	public function testAdminSubDomainsUpdate()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$data = [
			'domainname' => 'mysub.test2.local',
			'path' => 'mysub.test2.local',
			'isemaildomain' => 1,
			'customerid' => $customer_userdata['customerid']
		];
		$json_result = SubDomains::getLocal($admin_userdata, $data)->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals($customer_userdata['documentroot'] . 'mysub.test2.local/', $result['documentroot']);
	}

	/**
	 * @depends testAdminSubDomainsUpdate
	 */
	public function testCustomerSubDomainsUpdate()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$data = [
			'domainname' => 'mysub.test2.local',
			'url' => 'https://www.froxlor.org/',
			'isemaildomain' => 0,
		];
		$json_result = SubDomains::getLocal($customer_userdata, $data)->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('https://www.froxlor.org/', $result['documentroot']);
	}

	public function testCustomerSubDomainsList()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$json_result = SubDomains::getLocal($customer_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(3, $result['count']);
	}

	public function testResellerSubDomainsList()
	{
		global $admin_userdata;
		// get reseller
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
		$reseller_userdata['adminsession'] = 1;
		$json_result = SubDomains::getLocal($reseller_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(3, $result['count']);
	}

	public function testAdminSubDomainsListWithCustomer()
	{
		global $admin_userdata;
		$json_result = SubDomains::getLocal($admin_userdata, [
			'loginname' => 'test1'
		])->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(3, $result['count']);
	}

	/**
	 * @depends testCustomerSubDomainsList
	 */
	public function testCustomerSubDomainsDelete()
	{
		global $admin_userdata;
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$json_result = SubDomains::getLocal($customer_userdata, [
			'domainname' => 'mysub.test2.local'
		])->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('mysub.test2.local', $result['domain']);
		$this->assertEquals($customer_userdata['customerid'], $result['customerid']);
	}
}
