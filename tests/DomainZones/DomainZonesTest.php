<?php
use PHPUnit\Framework\TestCase;

/**
 *
 * @covers ApiCommand
 * @covers ApiParameter
 * @covers SubDomains
 * @covers DomainZones
 */
class DomainZonesTest extends TestCase
{

	public function testCustomerDomainZonesGet()
	{
		global $admin_userdata;
		
		Settings::Set('system.dnsenabled', 1, true);
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'domainname' => 'test2.local'
		];
		$json_result = DomainZones::getLocal($customer_userdata, $data)->get();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue(count($result) > 1);
		$this->assertEquals('$ORIGIN test2.local.', $result[1]);
	}

	public function testCustomerDomainZonesGetNoSubdomains()
	{
		global $admin_userdata;
		
		Settings::Set('system.dnsenabled', 1, true);
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'domainname' => 'mysub2.test2.local'
		];
		$this->expectExceptionCode(406);
		$this->expectExceptionMessage("DNS zones can only be generated for the main domain, not for subdomains");
		DomainZones::getLocal($customer_userdata, $data)->get();
	}
	
	public function testAdminDomainZonesListing()
	{
		global $admin_userdata;
		$this->expectExceptionCode(303);
		DomainZones::getLocal($admin_userdata)->listing();
	}
	
	public function testAdminDomainZonesUpdate()
	{
		global $admin_userdata;
		$this->expectExceptionCode(303);
		DomainZones::getLocal($admin_userdata)->update();
	}
}
