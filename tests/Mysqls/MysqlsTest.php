<?php
use PHPUnit\Framework\TestCase;

/**
 *
 * @covers ApiCommand
 * @covers ApiParameter
 * @covers Mysqls
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
			'sendinfomail' => true
		];
		$json_result = Mysqls::getLocal($customer_userdata, $data)->add();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals('testdb', $result['description']);
		$this->assertEquals(0, $result['dbserver']);
	}
}
