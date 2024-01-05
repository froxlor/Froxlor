<?php

use Froxlor\Api\Commands\Froxlor;
use PHPUnit\Framework\TestCase;

/**
 *
 * @covers \Froxlor\Api\ApiCommand
 * @covers \Froxlor\Api\ApiParameter
 * @covers \Froxlor\Froxlor
 */
class FroxlorTest extends TestCase
{

	public function testFroxlorcheckUpdate()
	{
		global $admin_userdata;

		$json_result = Froxlor::getLocal($admin_userdata)->checkUpdate();
		$result = json_decode($json_result, true)['data'];
		$this->assertContains($result['isnewerversion'] ?? -1, [0, 1]);
		$this->assertNotEmpty($result['version']);
	}
}
