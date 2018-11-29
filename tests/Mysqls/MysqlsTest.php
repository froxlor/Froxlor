<?php
use PHPUnit\Framework\TestCase;

/**
 *
 * @covers ApiCommand
 * @covers ApiParameter
 * @covers Mysqls
 * @covers Customers
 * @covers Admins
 */
class MysqlsTest extends TestCase
{

	public function testCustomerMysqlsAdd()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'mysql_password' => generatePassword(),
			'description' => 'testdb',
			'sendinfomail' => TRAVIS_CI == 1 ? 0 : 1
		];
		$json_result = Mysqls::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('testdb', $result['description']);
		$this->assertEquals(0, $result['dbserver']);
	}
	
	/**
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
	 * @depends testCustomerMysqlsAdd
	 */
	public function testResellerMysqlsGet()
	{
		global $admin_userdata;
		// get reseller
		$json_result = Admins::getLocal($admin_userdata, array(
			'loginname' => 'reseller'
		))->get();
		$reseller_userdata = json_decode($json_result, true)['data'];
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
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'dbname' => 'test1sql5'
		];
		$this->expectExceptionCode(404);
		$this->expectExceptionMessage("MySQL database with dbname 'test1sql5' could not be found");
		Mysqls::getLocal($customer_userdata, $data)->get();
	}
	
	/**
	 * @depends testCustomerMysqlsAdd
	 */
	public function testAdminMysqlsUpdate()
	{
		global $admin_userdata;
		
		$json_result = Mysqls::getLocal($admin_userdata, array(
			'dbname' => 'test1sql1'
		))->get();
		$old_db = json_decode($json_result, true)['data'];
		
		$data = [
			'dbname' => 'test1sql1',
			'mysql_password' => generatePassword(),
			'description' => 'testdb-upd',
			'loginname' => 'test1'
		];
		$json_result = Mysqls::getLocal($admin_userdata, $data)->update();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('testdb-upd', $result['description']);
	}
	
	/**
	 * @depends testCustomerMysqlsAdd
	 */
	public function testCustomerMysqlsList()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];

		$json_result = Mysqls::getLocal($customer_userdata)->listing();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(1, $result['count']);
		$this->assertEquals('test1sql1', $result['list'][0]['databasename']);
	}
	
	/**
	 * @depends testCustomerMysqlsList
	 */
	public function testCustomerMysqlsDelete()
	{
		global $admin_userdata;
		
		// get customer
		$json_result = Customers::getLocal($admin_userdata, array(
			'loginname' => 'test1'
		))->get();
		$customer_userdata = json_decode($json_result, true)['data'];
		
		$data = [
			'dbname' => 'test1sql1'
		];
		$json_result = Mysqls::getLocal($customer_userdata, $data)->delete();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('test1sql1', $result['databasename']);
	}
}
