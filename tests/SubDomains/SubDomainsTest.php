<?php
use PHPUnit\Framework\TestCase;

/**
 * @covers ApiCommand
 * @covers SubDomains
 * @covers Domains
 */
class SubDomainsTest extends TestCase
{
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
}
