<?php

use PHPUnit\Framework\TestCase;

use Froxlor\System\IPTools;

/**
 *
 * @covers \Froxlor\System\IPTools
 */
class IPToolsTest extends TestCase
{
	public function testValidateIPv6()
	{
		$result = IPTools::is_ipv6('1.1.1.1/4');
		$this->assertFalse($result);
		$result = IPTools::is_ipv6('1.1.1.1');
		$this->assertFalse($result);
		$result = IPTools::is_ipv6('::ffff:10.20.30.40');
		$this->assertEquals('::ffff:10.20.30.40', $result);
		$result = IPTools::is_ipv6('2620:0:2d0:200::7/32');
		$this->assertFalse($result);
		$result = IPTools::is_ipv6('2620:0:2d0:200::7');
		$this->assertEquals('2620:0:2d0:200::7', $result);
	}

	public function testValidateIPinRange()
	{
		$result = IPTools::ip_in_range([0=>'82.149.225.46',1=>24], '123.213.132.1');
		$this->assertFalse($result);
		$result = IPTools::ip_in_range([0=>'82.149.225.46',1=>24], '2620:0:2d0:200::7');
		$this->assertFalse($result);
		$result = IPTools::ip_in_range([0=>'82.149.225.46',1=>24], '82.149.225.152');
		$this->assertTrue($result);
		$result = IPTools::ip_in_range([0=>'2620:0:2d0:200::1',1=>116], '2620:0:2d0:200::fff1');
		$this->assertFalse($result);
		$result = IPTools::ip_in_range([0=>'2620:0:2d0:200::1',1=>64], '2620:0:2d0:200::fff1');
		$this->assertTrue($result);
	}
}
