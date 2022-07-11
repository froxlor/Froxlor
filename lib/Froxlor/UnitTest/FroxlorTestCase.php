<?php
namespace Froxlor\UnitTest;

use Exception;
use PHPUnit\Framework\TestCase;
use Froxlor\FileDir;
use Froxlor\Api\Commands\Admins;
use Froxlor\Api\Commands\Customers;
use Froxlor\Api\Commands\Domains;


class FroxlorTestCase extends TestCase {
	protected static $admin_userdata;
	protected static $testcase_outputdir;

	private $testcase_customer;
	private $testcase_domain_ids = array();

	public static function setFroxlorAdminUserdata($admin_user)
	{
		self::$admin_userdata = $admin_user;
	}

	public static function setFroxlorTestOutputDir($path)
	{
		self::$testcase_outputdir = rtrim($path, '/');
		@mkdir(self::$testcase_outputdir, 0755, true);
	}
	
	public static function setUpBeforeClass() : void
	{
		if(!empty(self::$testcase_outputdir)) {
			FileDir::setFroxlorTestPathPrefix(self::$testcase_outputdir);
		}
	}

	public static function tearDownAfterClass() : void
	{
		FileDir::setFroxlorTestPathPrefix(null);
	}

	public function tearDown() : void
	{
		if ($this->testcase_customer != null) {
			Customers::getLocal(self::$admin_userdata, array(
				'loginname' => $this->testcase_customer['loginname']
			))->delete();
		}
		$this->testcase_domain_ids = array();
	}

	protected function getFroxlorValidNameByClass() {
		array('\\', ':');
		return str_replace('\'', '_', get_class($this));
	}

	/**
	 * Creates a test customer for this test, or returns the same customer via api
	 * @return array
	 */
	protected function getFroxlorTestCustomer() 
	{
		$loginname = $this->getFroxlorValidNameByClass();
		if ($this->testcase_customer != null) {
			$json_result = Customers::getLocal(self::$admin_userdata, array(
				'loginname' => $loginname,
			))->get();
			$this->testcase_customer = json_decode($json_result, true)['data'];
			return $this->testcase_customer;
		}
		
		try {
			// old broken unit test run, first try to get the customer, and then delete it.
			$json_result = Customers::getLocal(self::$admin_userdata, array(
				'loginname' => $loginname,
			))->get();

			$customer_userdata = json_decode($json_result, true)['data'];
			if ($customer_userdata) {
				Customers::getLocal(self::$admin_userdata, array(
					'loginname' => $loginname,
				))->delete();
			}
		} catch(\Exception $e) {

		}
		
		$data = [
			'new_loginname' => $loginname,
			'email' => 'team@froxlor.org',
			'firstname' => 'Test',
			'name' => 'Testman',
			'customernumber' => 1337,
			'diskspace' => 0,
			'diskspace_ul' => 1,
			'traffic' => - 1,
			'subdomains' => 15,
			'emails' => - 1,
			'email_accounts' => 15,
			'email_forwarders' => 15,
			'email_imap' => 1,
			'email_pop3' => 0,
			'ftps' => 15,
			'mysqls' => 15,
			'createstdsubdomain' => 1,
			'new_customer_password' => 'h0lYmo1y',
			'sendpassword' => 0,
			'phpenabled' => 1,
			'dnsenabled' => 1,
			'store_defaultindex' => 1,
			'custom_notes' => 'secret',
			'custom_notes_show' => 0,
			'gender' => 5,
			'allowed_phpconfigs' => array(
				1
			)
		];

		
		$json_result = Customers::getLocal(self::$admin_userdata, $data)->add();
		$this->testcase_customer = json_decode($json_result, true)['data'];
		return $this->testcase_customer;		
	}
	
	/**
	 * Creates a new domain in databse via api 
	 * When necessary creates a test customer via getFroxlorTestCustomer
	 * @return array New domain data
	 */
	protected function createFroxlorTestDomain(array $addionaldata = array()) {
		$customer = $this->getFroxlorTestCustomer();
		$domainname =  $this->getFroxlorValidNameByClass().'-'.count($this->testcase_domain_ids).'.local';

		$data = array(
			'domain' => $domainname,
			'customerid' => $customer['customerid'],
			'description' => 'Created for '.get_class($this),
		);
		$data = array_merge_recursive($data, $addionaldata);
		$json_result = Domains::getLocal(self::$admin_userdata, $data)->add();
		$domain = json_decode($json_result, true)['data'];
		$this->assertArrayHasKey('domain', $domain);
		$this->testcase_domain_ids[$domain['id']] = $domain;
		return $domain;
	}

	/**
	 * Get or refresh an vaild domain from database via api
	 * @param array $prevdomain Old domain data
	 * @return array domain data
	 */
	protected function getFroxlorTestDomain($prevdomain) {
		$id = $prevdomain['id'];

		$data = array(
			'id' => $id,
		);
		$json_result = Domains::getLocal(self::$admin_userdata, $data)->get();
		$domain = json_decode($json_result, true)['data'];
		$this->assertArrayHasKey('domain', $domain);
		$this->assertEquals( $domain['id'] , $id);
		$this->testcase_domain_ids[$domain['id']] = $domain;
		return $domain;
	}

	/**
	 * Update the domain in database via api
	 * @param array $prevdomain Old domain data
	 * @param array $newdata new domain data
	 * @return array domain data
	 */
	protected function updateFroxlorTestDomain($prevdomain, $newdata) {
		$id = $prevdomain['id'];
		$newdata['id'] =  $id;
		$json_result = Domains::getLocal(self::$admin_userdata, $newdata)->update();
		$domain = json_decode($json_result, true)['data'];
		$this->assertArrayHasKey('domain', $domain);
		$this->assertEquals( $domain['id'] , $id);
		$this->testcase_domain_ids[$domain['id']] = $domain;
		return $domain;
	}
}
