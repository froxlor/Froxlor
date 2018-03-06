<?php
use PHPUnit\Framework\TestCase;

/**
 * @covers ApiCommand
 * @covers Emails
 */
class MailsTest extends TestCase
{
	public function testCustomerEmailsAdd()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'email_part' => 'info',
			'domain' => 'test2.local'
		];
		$json_result = Emails::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals("info@test2.local", $result['email_full']);
		$this->assertEquals(0, $result['iscatchall']);
	}
	
	public function testAdminEmailsAdd()
	{
		global $admin_userdata;
		$data = [
			'email_part' => 'catchall',
			'domain' => 'test2.local',
			'iscatchall' => 1,
			'customer_id' => 1
		];
		$json_result = Emails::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals("catchall@test2.local", $result['email_full']);
		$this->assertEquals(1, $result['iscatchall']);
	}
}
