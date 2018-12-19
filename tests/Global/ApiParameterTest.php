<?php
use PHPUnit\Framework\TestCase;

use Froxlor\Api\Commands\Froxlor;

/**
 *
 * @covers \Froxlor\Api\ApiCommand
 * @covers \Froxlor\Api\ApiParameter
 * @covers \Froxlor\Froxlor
 */
class ApiParameterTest extends TestCase
{

	public function testMissingRequiredParameter()
	{
		global $admin_userdata;
		$this->expectExceptionCode(404);
		$this->expectExceptionMessage('Requested parameter "key" could not be found for "Froxlor:getSetting"');
		Froxlor::getLocal($admin_userdata)->getSetting();
	}
}
