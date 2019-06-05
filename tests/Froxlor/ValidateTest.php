<?php
use PHPUnit\Framework\TestCase;

use Froxlor\Validate\Validate;

/**
 *
 * @covers \Froxlor\Validate\Validate
 * @covers \Froxlor\UI\Response
 * @covers \Froxlor\FroxlorLogger
 */
class ValidateTest extends TestCase
{

	public function testValidate()
	{
		$teststr = Validate::validate("user input", "test-field", '', '', [], true);
		$this->assertEquals("user input", $teststr);
	}

	public function testValidateStrInEmptyDefault()
	{
		$teststr = Validate::validate("user input", "test-field", '', '', [
			"user test",
			"user input",
			"user bla"
		], true);
		$this->assertEquals("user input", $teststr);
	}

	public function testValidateEmptyDefaultNoArray()
	{
		$teststr = Validate::validate("user input", "test-field", '', '', "user input", true);
		$this->assertEquals("user input", $teststr);
	}

	public function testValidateRemoveNotAllowedChar()
	{
		$teststr = Validate::validate("user " . PHP_EOL . "input", "test-field", '', '', [], true);
		$this->assertEquals("user input", $teststr);
	}

	public function testValidateStringFormatError()
	{
		$this->expectException("Exception");
		$this->expectExceptionCode(400);
		Validate::validate("user input", "test-field", '/^[A-Z]+$/i', '', [], true);
	}

	public function testValidateIp()
	{
		$result = Validate::validate_ip2("12.34.56.78", false, 'invalidip', false, false, false, true);
		$this->assertEquals("12.34.56.78", $result);
	}

	public function testValidateIpPrivNotAllowed()
	{
		$this->expectException("Exception");
		$this->expectExceptionCode(400);
		Validate::validate_ip2("10.0.0.1", false, 'invalidip', false, false, false, true);
	}

	public function testValidateIpPrivNotAllowedBool()
	{
		$result = Validate::validate_ip2("10.0.0.1", true, 'invalidip', false, false, false, true);
		$this->assertFalse($result);
	}

	public function testValidateIpCidrNotAllowed()
	{
		$this->expectException("Exception");
		$this->expectExceptionCode(400);
		Validate::validate_ip2("12.34.56.78/24", false, 'invalidip', false, false, false, true);
	}

	public function testValidateIpCidrNotAllowedBool()
	{
		$result = Validate::validate_ip2("12.34.56.78/24", true, 'invalidip', false, false, false, true);
		$this->assertFalse($result);
	}

	public function testValidateIpCidr()
	{
		$result = Validate::validate_ip2("12.34.56.78/24", false, 'invalidip', false, false, true, true);
		$this->assertEquals("12.34.56.78/24", $result);
	}

	public function testValidateIpLocalhostAllowed()
	{
		$result = Validate::validate_ip2("127.0.0.1/32", false, 'invalidip', true, false, true, true);
		$this->assertEquals("127.0.0.1/32", $result);
	}

	public function testValidateIpLocalhostAllowedWrongIp()
	{
		$this->expectException("Exception");
		$this->expectExceptionCode(400);
		Validate::validate_ip2("127.0.0.2", false, 'invalidip', true, false, false, true);
	}
}
