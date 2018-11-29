<?php
use PHPUnit\Framework\TestCase;

/**
 *
 * @covers ApiCommand
 * @covers ApiParameter
 * @covers Emails
 * @covers EmailForwarders
 * @covers EmailAccounts
 * @covers Customers
 * @covers Admins
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
			'customerid' => 1
		];
		$json_result = Emails::getLocal($admin_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals("catchall@test2.local", $result['email_full']);
		$this->assertEquals(1, $result['iscatchall']);
	}

	public function testAdminEmailsUpdate()
	{
		global $admin_userdata;
		$data = [
			'emailaddr' => 'catchall@test2.local',
			'iscatchall' => 0,
			'customerid' => 1
		];
		$json_result = Emails::getLocal($admin_userdata, $data)->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(0, $result['iscatchall']);
	}

	public function testCustomerEmailsUpdate()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'emailaddr' => 'catchall@test2.local',
			'iscatchall' => 1
		];
		$json_result = Emails::getLocal($customer_userdata, $data)->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['iscatchall']);
	}

	public function testCustomerEmailForwardersAdd()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'emailaddr' => 'info@test2.local',
			'destination' => 'other@domain.tld'
		];
		$json_result = EmailForwarders::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('other@domain.tld', $result['destination']);
	}

	/**
	 *
	 * @depends testCustomerEmailForwardersAdd
	 */
	public function testCustomerEmailForwardersAddNoMoreResources()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$customer_userdata['email_forwarders_used'] = $customer_userdata['email_forwarders'];
		$this->expectExceptionCode(406);
		$this->expectExceptionMessage("No more resources available");
		EmailForwarders::getLocal($customer_userdata)->add();
	}

	/**
	 *
	 * @depends testCustomerEmailForwardersAddNoMoreResources
	 */
	public function testCustomerEmailForwardersAddEmailHidden()
	{
		global $admin_userdata;

		Settings::Set('panel.customer_hide_options', 'email', true);

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(405);
		$this->expectExceptionMessage("You cannot access this resource");
		EmailForwarders::getLocal($customer_userdata)->add();
	}

	/**
	 *
	 * @depends testCustomerEmailForwardersAddEmailHidden
	 */
	public function testCustomerEmailForwardersDeleteEmailHidden()
	{
		global $admin_userdata;

		Settings::Set('panel.customer_hide_options', 'email', true);

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		$this->expectExceptionCode(405);
		$this->expectExceptionMessage("You cannot access this resource");
		EmailForwarders::getLocal($customer_userdata)->delete();
	}

	/**
	 *
	 * @depends testCustomerEmailForwardersDeleteEmailHidden
	 */
	public function testCustomerEmailForwardersAddAnother()
	{
		global $admin_userdata;

		Settings::Set('panel.customer_hide_options', '', true);

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'emailaddr' => 'info@test2.local',
			'destination' => 'other2@domain.tld'
		];
		$json_result = EmailForwarders::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('other@domain.tld other2@domain.tld', $result['destination']);
	}

	/**
	 *
	 * @depends testCustomerEmailForwardersDeleteEmailHidden
	 */
	public function testCustomerEmailForwardersAddWithSpaces()
	{
		global $admin_userdata;

		Settings::Set('panel.customer_hide_options', '', true);

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'emailaddr' => 'info@test2.local',
			'destination' => 'other3@domain.tld  '
		];
		$json_result = EmailForwarders::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('other@domain.tld other2@domain.tld other3@domain.tld', $result['destination']);
	}

	/**
	 *
	 * @depends testCustomerEmailForwardersAdd
	 */
	public function testCustomerEmailForwardersAddExistingAsMail()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'emailaddr' => 'info@test2.local',
			'destination' => 'info@test2.local'
		];
		$this->expectExceptionMessage("The forwarder to info@test2.local already exists as active email-address.");
		EmailForwarders::getLocal($customer_userdata, $data)->add();
	}

	/**
	 *
	 * @depends testCustomerEmailForwardersAdd
	 */
	public function testCustomerEmailForwardersAddExistingAsDestination()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'emailaddr' => 'info@test2.local',
			'destination' => 'other@domain.tld'
		];
		$this->expectExceptionMessage('You have already defined a forwarder to "other@domain.tld"');
		EmailForwarders::getLocal($customer_userdata, $data)->add();
	}

	public function testCustomerEmailForwardersAddInvalid()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'emailaddr' => 'info@test2.local',
			'destination' => '@domain.com'
		];
		$this->expectExceptionMessage("The forwarder domain.com contains invalid character(s) or is incomplete.");
		EmailForwarders::getLocal($customer_userdata, $data)->add();
	}

	public function testAdminEmailForwadersUndefinedGet()
	{
		global $admin_userdata;
		$this->expectExceptionCode(303);
		EmailForwarders::getLocal($admin_userdata)->get();
	}

	public function testAdminEmailForwadersUndefinedUpdate()
	{
		global $admin_userdata;
		$this->expectExceptionCode(303);
		EmailForwarders::getLocal($admin_userdata)->update();
	}

	public function testAdminEmailForwadersUndefinedListing()
	{
		global $admin_userdata;
		$this->expectExceptionCode(303);
		EmailForwarders::getLocal($admin_userdata)->listing();
	}

	/**
	 *
	 * @depends testCustomerEmailForwardersAddAnother
	 */
	public function testCustomerEmailForwardersDelete()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'emailaddr' => 'info@test2.local',
			'forwarderid' => 1
		];
		$json_result = EmailForwarders::getLocal($customer_userdata, $data)->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('other@domain.tld other3@domain.tld', $result['destination']);
	}

	/**
	 *
	 * @depends testCustomerEmailForwardersAddAnother
	 */
	public function testCustomerEmailForwardersDeleteUnknown()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'emailaddr' => 'info@test2.local',
			'forwarderid' => 1337
		];
		$this->expectExceptionCode(404);
		$this->expectExceptionMessage("Unknown forwarder id");
		EmailForwarders::getLocal($customer_userdata, $data)->delete();
	}

	public function testCustomerEmailsListing()
	{
		global $admin_userdata;

		Settings::Set('panel.customer_hide_options', '', true);

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$json_result = Emails::getLocal($customer_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(2, $result['count']);
		$this->assertEquals("info@test2.local", $result['list'][0]['email']);
		$this->assertEquals("@test2.local", $result['list'][1]['email']);
	}

	public function testCustomerEmailAccountsAdd()
	{
		global $admin_userdata;

		Settings::Set('panel.sendalternativemail', 1, true);
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'emailaddr' => 'info@test2.local',
			'email_password' => generatePassword(),
			'alternative_email' => 'noone@example.com',
			'email_quota' => 1337,
			'sendinfomail' => TRAVIS_CI == 1 ? 0 : 1
		];
		$json_result = EmailAccounts::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['popaccountid']);
	}

	public function testAdminEmailAccountsUpdate()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'emailaddr' => 'info@test2.local',
			'email_password' => generatePassword(),
			'alternative_email' => 'noone@example.com',
			'email_quota' => 1338
		];
		$json_result = EmailAccounts::getLocal($customer_userdata, $data)->update();
		$result = json_decode($json_result, true)['data'];
		// quota is disabled
		$this->assertEquals(0, $result['quota']);
	}

	public function testAdminEmailAccountsUndefinedGet()
	{
		global $admin_userdata;
		$this->expectExceptionCode(303);
		EmailAccounts::getLocal($admin_userdata)->get();
	}

	public function testAdminEmailAccountsUndefinedListing()
	{
		global $admin_userdata;
		$this->expectExceptionCode(303);
		EmailAccounts::getLocal($admin_userdata)->listing();
	}

	public function testCustomerEmailAccountsDelete()
	{
		global $admin_userdata;

		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$data = [
			'emailaddr' => 'info@test2.local',
			'delete_userfiles' => 1
		];
		$json_result = EmailAccounts::getLocal($customer_userdata, $data)->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(0, $result['popaccountid']);
	}

	public function testCustomerEmailsDelete()
	{
		global $admin_userdata;

		// remove possible existing delete tasks
		Database::query("TRUNCATE `" . TABLE_PANEL_TASKS . "`");

		Settings::Set('panel.sendalternativemail', 0, true);
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		// add account
		$data = [
			'emailaddr' => 'info@test2.local',
			'email_password' => generatePassword(),
			'alternative_email' => 'noone@example.com',
			'sendinfomail' => TRAVIS_CI == 1 ? 0 : 1
		];
		$json_result = EmailAccounts::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(2, $result['popaccountid']);

		// now delete the whole address
		$data = [
			'emailaddr' => 'info@test2.local',
			'delete_userfiles' => 1
		];
		$json_result = Emails::getLocal($customer_userdata, $data)->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals("info@test2.local", $result['email_full']);
	}
}
