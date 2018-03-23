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

	/**
	 * @depends testCustomerDomainZonesGet
	 */
	public function testCustomerDomainZonesGetNoSubdomains()
	{
		global $admin_userdata;
		
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

	/**
	 * @depends testCustomerDomainZonesGet
	 */
	public function testCustomerDomainZonesAddA()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'domainname' => 'test2.local',
			'record' => 'www2',
			'type' => 'A',
			'content' => '127.0.0.1'
		];
		$json_result = DomainZones::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue(count($result) > 1);
		$found = false;
		foreach ($result as $entry) {
			if (substr($entry, 0, 4) == 'www2') {
				$found = true;
				break;
			}
		}
		$this->assertTrue($found);
		$this->assertEquals('www2	18000	IN	A	127.0.0.1', $entry);
	}
	
	/**
	 * @depends testCustomerDomainZonesAddA
	 */
	public function testCustomerDomainZonesAddAInvalid()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'domainname' => 'test2.local',
			'record' => 'www3',
			'type' => 'A',
			'content' => 'a.b.c.d',
			'ttl' => -1
		];
		$this->expectExceptionMessage("No valid IP address for A-record given");
		DomainZones::getLocal($customer_userdata, $data)->add();
	}
	
	/**
	 * @depends testCustomerDomainZonesAddA
	 */
	public function testCustomerDomainZonesAddADuplicate()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'domainname' => 'test2.local',
			'record' => 'www2',
			'type' => 'A',
			'content' => '127.0.0.1',
			'ttl' => -1
		];
		$this->expectExceptionMessage("Record already exists");
		DomainZones::getLocal($customer_userdata, $data)->add();
	}
	
	/**
	 * @depends testCustomerDomainZonesGet
	 */
	public function testCustomerDomainZonesAddAAAA()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'domainname' => 'test2.local',
			'record' => 'www3',
			'type' => 'AAAA',
			'content' => '::1'
		];
		$json_result = DomainZones::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue(count($result) > 1);
		$found = false;
		foreach ($result as $entry) {
			if (substr($entry, 0, 4) == 'www3') {
				$found = true;
				break;
			}
		}
		$this->assertTrue($found);
		$this->assertEquals('www3	18000	IN	AAAA	::1', $entry);
	}
	
	/**
	 * @depends testCustomerDomainZonesAddA
	 */
	public function testCustomerDomainZonesAddAAAAInvalid()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'domainname' => 'test2.local',
			'record' => 'www4',
			'type' => 'AAAA',
			'content' => 'z:z123.123',
			'ttl' => -1
		];
		$this->expectExceptionMessage("No valid IP address for AAAA-record given");
		DomainZones::getLocal($customer_userdata, $data)->add();
	}
	
	public function testAdminDomainZonesAddMX()
	{
		global $admin_userdata;

		$data = [
			'domainname' => 'test2.local',
			'record' => '',
			'type' => 'MX',
			'prio' => 10,
			'content' => 'mail.example.com.'
		];
		$json_result = DomainZones::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue(count($result) > 1);
		$found = false;
		foreach ($result as $entry) {
			if (substr($entry, strlen('mail.example.com.') * -1) == 'mail.example.com.') {
				$found = true;
				break;
			}
		}
		$this->assertTrue($found);
		$this->assertEquals('@	18000	IN	MX	10	mail.example.com.', $entry);
	}
	
	/**
	 * @depends testAdminDomainZonesAddMX
	 */
	public function testAdminDomainZonesAddMXNoPrio()
	{
		global $admin_userdata;
		
		$data = [
			'domainname' => 'test2.local',
			'record' => '',
			'type' => 'MX',
			'content' => 'mail.example.com.'
		];
		$this->expectExceptionMessage("Invalid MX priority given");
		DomainZones::getLocal($admin_userdata, $data)->add();
	}

	/**
	 * @depends testAdminDomainZonesAddMX
	 */
	public function testAdminDomainZonesAddMXInvalid()
	{
		global $admin_userdata;
		
		$data = [
			'domainname' => 'test2.local',
			'record' => '',
			'type' => 'MX',
			'prio' => 20,
			'content' => 'localhost'
		];
		$this->expectExceptionMessage("The MX content value must be a valid domain-name");
		DomainZones::getLocal($admin_userdata, $data)->add();
	}
	
	public function testAdminDomainZonesAddCname()
	{
		global $admin_userdata;
		
		$data = [
			'domainname' => 'test2.local',
			'record' => 'db',
			'type' => 'CNAME',
			'content' => 'db.example.com.'
		];
		$json_result = DomainZones::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue(count($result) > 1);
		$found = false;
		foreach ($result as $entry) {
			if (substr($entry, strlen('db.example.com.') * -1) == 'db.example.com.') {
				$found = true;
				break;
			}
		}
		$this->assertTrue($found);
		$this->assertEquals('db	18000	IN	CNAME	db.example.com.', $entry);
	}
	
	public function testAdminDomainZonesAddCnameLocal()
	{
		global $admin_userdata;
		
		$data = [
			'domainname' => 'test2.local',
			'record' => 'db',
			'type' => 'CNAME',
			'content' => 'db2'
		];
		$json_result = DomainZones::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue(count($result) > 1);
		$found = false;
		foreach ($result as $entry) {
			if (substr($entry, strlen('db2.test2.local.') * -1) == 'db2.test2.local.') {
				$found = true;
				break;
			}
		}
		$this->assertTrue($found);
		$this->assertEquals('db	18000	IN	CNAME	db2.test2.local.', $entry);
	}
	
	/**
	 * @depends testAdminDomainZonesAddCname
	 */
	public function testAdminDomainZonesAddCnameInvalid()
	{
		global $admin_userdata;
		
		$data = [
			'domainname' => 'test2.local',
			'record' => '',
			'type' => 'CNAME',
			'content' => 'localhost.'
		];
		$this->expectExceptionMessage("Invalid domain-name for CNAME record");
		DomainZones::getLocal($admin_userdata, $data)->add();
	}
	
	public function testAdminDomainZonesAddNS()
	{
		global $admin_userdata;
		
		$data = [
			'domainname' => 'test2.local',
			'record' => '',
			'type' => 'NS',
			'content' => 'ns.example.com.'
		];
		$json_result = DomainZones::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue(count($result) > 1);
		$found = false;
		foreach ($result as $entry) {
			if (substr($entry, strlen('ns.example.com.') * -1) == 'ns.example.com.') {
				$found = true;
				break;
			}
		}
		$this->assertTrue($found);
		$this->assertEquals('@	18000	IN	NS	ns.example.com.', $entry);
	}

	public function testAdminDomainZonesAddNsInvalid()
	{
		global $admin_userdata;
		
		$data = [
			'domainname' => 'test2.local',
			'record' => '',
			'type' => 'NS',
			'content' => 'localhost.'
		];
		$this->expectExceptionMessage("Invalid domain-name for NS record");
		DomainZones::getLocal($admin_userdata, $data)->add();
	}
	
	public function testAdminDomainZonesAddTXT()
	{
		global $admin_userdata;
		
		$data = [
			'domainname' => 'test2.local',
			'record' => '_test1',
			'type' => 'TXT',
			'content' => 'aw yeah'
		];
		$json_result = DomainZones::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue(count($result) > 1);
		$found = false;
		foreach ($result as $entry) {
			if (substr($entry, 0, 6) == '_test1') {
				$found = true;
				break;
			}
		}
		$this->assertTrue($found);
		$this->assertEquals('_test1	18000	IN	TXT	aw yeah', $entry);
	}
	
	public function testAdminDomainZonesAddSRV()
	{
		global $admin_userdata;
		
		$data = [
			'domainname' => 'test2.local',
			'record' => '_test2',
			'type' => 'SRV',
			'prio' => 50,
			'content' => '2 1 srv.example.com.'
		];
		$json_result = DomainZones::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertTrue(count($result) > 1);
		$found = false;
		foreach ($result as $entry) {
			if (substr($entry, 0, 6) == '_test2') {
				$found = true;
				break;
			}
		}
		$this->assertTrue($found);
		$this->assertEquals('_test2	18000	IN	SRV	50	2 1 srv.example.com.', $entry);
	}
	
	public function testAdminDomainZonesAddSrvInvalid()
	{
		global $admin_userdata;
		
		$data = [
			'domainname' => 'test2.local',
			'record' => '_test2',
			'type' => 'SRV',
			'prio' => 50,
			'content' => 'srv.example.com.'
		];
		$this->expectExceptionMessage("Invalid SRV content, must contain of fields weight, port and target, e.g.: 5 5060 sipserver.example.com.");
		DomainZones::getLocal($admin_userdata, $data)->add();
	}
	
	public function testCustomerDomainZonesDelete()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'domainname' => 'test2.local',
			'entry_id' => 1
		];
		$json_result = DomainZones::getLocal($customer_userdata, $data)->delete();
		$result = json_decode($json_result, true);
		$this->assertTrue($result['data']);
		$this->assertEquals(200, $result['status']);
	}
	
	public function testCustomerDomainZonesDeleteUnmodified()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'domainname' => 'test2.local',
			'entry_id' => 1337
		];
		$json_result = DomainZones::getLocal($customer_userdata, $data)->delete();
		$result = json_decode($json_result, true);
		$this->assertTrue($result['data']);
		$this->assertEquals(304, $result['status']);
	}
}
