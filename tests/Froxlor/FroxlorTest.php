<?php
use PHPUnit\Framework\TestCase;

/**
 *
 * @covers Froxlor
 */
class FroxlorTest extends TestCase
{

	public function testFroxlorcheckUpdate()
	{
		global $admin_userdata;

		$json_result = Froxlor::getLocal($admin_userdata)->checkUpdate();
		$result = json_decode($json_result, true)['data'];
		$this->assertEquals(0, $result['isnewerversion']);
		$this->assertEquals("You already have the latest version of Froxlor installed.", $result['additional_info']);
	}
}
