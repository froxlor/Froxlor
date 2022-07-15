<?php
use PHPUnit\Framework\TestCase;

use Froxlor\Settings;
use Froxlor\Api\Commands\Admins;
use Froxlor\Api\Commands\Customers;
use Froxlor\Api\Commands\Mysqls;
use Froxlor\Database\Database;
use Froxlor\Settings\Store;
use Froxlor\UnitTest\FroxlorTestCase;

/**
 *
 * @covers \Froxlor\Api\ApiCommand
 * @covers \Froxlor\Api\ApiParameter
 * @covers \Froxlor\Api\Commands\Mysqls
 * @covers \Froxlor\Api\Commands\Customers
 * @covers \Froxlor\Api\Commands\Admins
 * @covers \Froxlor\Database\DbManager
 * @covers \Froxlor\Database\Manager\DbManagerMySQL
 * @covers \Froxlor\Settings\Store
 */
class MysqlsTest extends FroxlorTestCase
{

	public function testCustomerMysqlsAdd()
	{
		// get customer
		$customer_userdata = $this->getFroxlorTestCustomerTest1();

		$newPwd = \Froxlor\System\Crypt::generatePassword();
		$data = [
			'mysql_password' => $newPwd,
			'description' => 'testdb',
			'sendinfomail' => FROXLORTEST_SENDMAIL ? 1 : 0
		];
		$json_result = Mysqls::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('testdb', $result['description']);
		$this->assertEquals(0, $result['dbserver']);

		// test connection
		try {
			$test_conn = new \PDO("mysql:host=127.0.0.1", 'test1sql1', $newPwd);
			unset($test_conn);
		} catch (PDOException $e) {
			$this->fail($e->getMessage());
		}

		$error = $this->hasSQLPasswordTableErrors('test1sql1');
		$this->assertFalse($error);
	}

	public function testCustomerMysqlsDBNameAdd() {
		// get customer
		$customer_userdata = $this->getFroxlorTestCustomerTest1();

		// Set customer.mysqlprefix to DBNAME
		Settings::Set('customer.mysqlprefix', 'DBNAME');

		$newPwd = \Froxlor\System\Crypt::generatePassword();
		$data = [
			'mysql_password' => $newPwd,
			'custom_suffix' => 'abc123',
			'description' => 'testdb',
			'sendinfomail' => FROXLORTEST_SENDMAIL ? 1 : 0
		];
		$json_result = Mysqls::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('test1_abc123', $result['databasename']);
		$this->assertEquals(0, $result['dbserver']);

		// test connection
		try {
			$test_conn = new \PDO("mysql:host=127.0.0.1", 'test1_abc123', $newPwd);
			unset($test_conn);
		} catch (PDOException $e) {
			$this->fail($e->getMessage());
		}
	}

	/**
	 *
	 * @depends testCustomerMysqlsAdd
	 */
	public function testAdminMysqlsGet()
	{
		global $admin_userdata;

		$json_result = Mysqls::getLocal($admin_userdata, array(
			'dbname' => 'test1sql1'
		))->get();
		$result = json_decode($json_result, true)['data'];

		$this->assertEquals('test1sql1', $result['databasename']);
		$this->assertEquals('testdb', $result['description']);
	}

	/**
	 *
	 * @depends testCustomerMysqlsAdd
	 */
	public function testResellerMysqlsGet()
	{
		$reseller_userdata = $this->getFroxlorTestReseller();
		$reseller_userdata['adminsession'] = 1;
		$json_result = Mysqls::getLocal($reseller_userdata, array(
			'dbname' => 'test1sql1'
		))->get();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('test1sql1', $result['databasename']);
		$this->assertEquals('testdb', $result['description']);
	}

	public function testCustomerMysqlsGetUnknown()
	{
		// get customer
		$customer_userdata = $this->getFroxlorTestCustomerTest1();

		$data = [
			'dbname' => 'test1sql5'
		];
		$this->expectExceptionCode(404);
		$this->expectExceptionMessage("MySQL database with dbname 'test1sql5' could not be found");
		Mysqls::getLocal($customer_userdata, $data)->get();
	}

	/**
	 *
	 * @depends testCustomerMysqlsAdd
	 */
	public function testAdminMysqlsUpdate()
	{
		global $admin_userdata;

		$newPwd = \Froxlor\System\Crypt::generatePassword();
		$data = [
			'dbname' => 'test1sql1',
			'mysql_password' => $newPwd,
			'description' => 'testdb-upd',
			'loginname' => 'test1'
		];
		$json_result = Mysqls::getLocal($admin_userdata, $data)->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('testdb-upd', $result['description']);

		// test connection
		try {
			$test_conn = new \PDO("mysql:host=127.0.0.1", 'test1sql1', $newPwd);
			unset($test_conn);
		} catch (PDOException $e) {
			$this->fail($e->getMessage());
		}

		$error = $this->hasSQLPasswordTableErrors('test1sql1');
		$this->assertFalse($error);
	}


	/**
	 *
	 * @depends testAdminMysqlsUpdate
	 */
	public function testAdminMysqlsUpdatePwdOnly()
	{
		global $admin_userdata;

		$newPwd = \Froxlor\System\Crypt::generatePassword();
		$data = [
			'dbname' => 'test1sql1',
			'mysql_password' => $newPwd,
			'loginname' => 'test1'
		];
		$json_result = Mysqls::getLocal($admin_userdata, $data)->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('testdb-upd', $result['description']);

		$error = $this->hasSQLPasswordTableErrors('test1sql1');
		$this->assertFalse($error);
	}

	/**
	 * Checks listing databases by customer
	 * (req db: test1sql1, test1_abc123)
	 * 
	 * @depends testCustomerMysqlsAdd
	 * @depends testCustomerMysqlsDBNameAdd
	 */
	public function testCustomerMysqlsList()
	{
		// get customer
		$customer_userdata = $this->getFroxlorTestCustomerTest1();

		$json_result = Mysqls::getLocal($customer_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(2, $result['count']);
		$this->assertEquals('test1sql1', $result['list'][0]['databasename']);
		$this->assertEquals('test1_abc123', $result['list'][1]['databasename']);

		$json_result = Mysqls::getLocal($customer_userdata)->listingCount();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(2, $result);
	}

	/**
	 *
	 * @depends testCustomerMysqlsAdd
	 */
	public function testCustomerMysqlsDelete()
	{
		// get customer
		$customer_userdata = $this->getFroxlorTestCustomerTest1();

		$data = [
			'dbname' => 'test1sql1'
		];
		$json_result = Mysqls::getLocal($customer_userdata, $data)->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('test1sql1', $result['databasename']);
	}

	/**
	 *
	 * @depends testCustomerMysqlsDBNameAdd
	 */
	public function testCustomerMysqlsDBNameDelete()
	{
		// get customer
		$customer_userdata = $this->getFroxlorTestCustomerTest1();

		$data = [
			'dbname' => 'test1_abc123'
		];
		$json_result = Mysqls::getLocal($customer_userdata, $data)->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('test1_abc123', $result['databasename']);
	}

	/**
	 *
	 * @depends testCustomerMysqlsAdd
	 */
	public function testStoreSettingIpAddress()
	{
		// this settings test is here because it directly changes mysql users / privileges
		$fielddata = array(
			'label' => 'serversettings.ipaddress',
			'settinggroup' => 'system',
			'varname' => 'ipaddress'
		);
		Store::storeSettingIpAddress('system_system_ipaddress', $fielddata, '82.149.225.47');

		$mysql_access_hosts = Settings::Get('system.mysql_access_host');
		$this->assertTrue(strpos($mysql_access_hosts, '82.149.225.47') !== false);

		$error = $this->hasSQLPasswordTableErrors(FROXLORTEST_DBUSER);
		$this->assertFalse($error);
	}

	/**
	 *
	 * @depends testStoreSettingIpAddress
	 */
	public function testGetAllSqlUsers()
	{
		\Froxlor\Database\Database::needRoot(true);
		$dbm = new \Froxlor\Database\DbManager(\Froxlor\FroxlorLogger::getInstanceOf());
		$users = $dbm->getManager()->getAllSqlUsers(false);

		$error = $this->hasSQLPasswordTableErrors('FROXLORTEST_DBUSER');
		$this->assertFalse($error);
		Database::needRoot(true);

		// just to be sure, not required for travis as the vm is fresh every time
		Database::query("DROP USER IF EXISTS ".FROXLORTEST_DBUSER."@10.0.0.10;");

		// grant privileges to another host
		$testdata = $users[FROXLORTEST_DBUSER];
		$dbm->getManager()->grantPrivilegesTo(FROXLORTEST_DBUSER, $testdata['password'], '10.0.0.10', true);

		// select all entries from mysql.user for froxlor010 to compare password-hashes
		$sel_stmt = Database::prepare("SELECT * FROM mysql.user WHERE `User` = :usr");
		Database::pexecute($sel_stmt, [
			'usr' => FROXLORTEST_DBUSER
		]);
		$results = $sel_stmt->fetchAll(\PDO::FETCH_ASSOC);
		foreach ($results as $user) {
			$passwd = $user['Password'] ?? $user['authentication_string'];
			$this->assertNotEmpty($passwd, 'No password for '.FROXLORTEST_DBUSER.' @ '.$user['Host']);
			$this->assertEquals($testdata['password'], $passwd);
		}

		// don't leak root access to other tests
		Database::needRoot(false);
	}

	/**
	 * Check for inconsistent mysql.user entries for db username
	 * - empty passwords
	 * 
	 * Note: resets root access
	 * @param string $username 
	 * @return false|string 
	 */
	protected function hasSQLPasswordTableErrors($username)
	{
		Database::needRoot(true);
		$sel_stmt = Database::prepare("SELECT * FROM mysql.user WHERE `User` = :usr");
		Database::pexecute($sel_stmt, [
			'usr' => $username
		]);

		$results = $sel_stmt->fetchAll(\PDO::FETCH_ASSOC);
		foreach ($results as $user) {
			$passwd = $user['Password'] ?? $user['authentication_string'];
			if (empty($passwd)) {
				$result = 'Empty password for '.$username.' @ '.$user['Host'];
				return $result;
			} 
		}

		Database::needRoot(false);
		return false;
	}
}
