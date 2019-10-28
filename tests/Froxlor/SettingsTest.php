<?php
use PHPUnit\Framework\TestCase;

/**
 *
 * @covers \Froxlor\Settings
 * @covers \Froxlor\Settings\FroxlorVhostSettings
 */
class SettingsTest extends TestCase
{

	protected function setUp(): void
	{
		// start fresh
		\Froxlor\Settings::Stash();
	}

	public function testSettingGet()
	{
		$syshostname = \Froxlor\Settings::Get('system.hostname');
		$this->assertEquals("dev.froxlor.org", $syshostname);
	}

	public function testSettingGetNoSeparator()
	{
		$nullval = \Froxlor\Settings::Get('system');
		$this->assertNull($nullval);
	}

	public function testSettingGetUnknown()
	{
		$nullval = \Froxlor\Settings::Get('thissetting.doesnotexist');
		$this->assertNull($nullval);
	}

	public function testSettingsAddNew()
	{
		\Froxlor\Settings::AddNew('temp.setting', 'empty');
		$actval = \Froxlor\Settings::Get('temp.setting');
		$this->assertEquals("empty", $actval);
	}

	public function testSettingsAddNewSettingExists()
	{
		$result = \Froxlor\Settings::AddNew('system.ipaddress', '127.0.0.1');
		$this->assertFalse($result);
	}

	/**
	 *
	 * @depends testSettingsAddNew
	 */
	public function testSettingSetNoSave()
	{
		$actval = \Froxlor\Settings::Get('temp.setting');
		$this->assertEquals("empty", $actval);
		\Froxlor\Settings::Set('temp.setting', 'temp-value', false);
		$tmpval = \Froxlor\Settings::Get('temp.setting');
		$this->assertEquals("temp-value", $tmpval);
		\Froxlor\Settings::Stash();
		$actval = \Froxlor\Settings::Get('temp.setting');
		$this->assertEquals("empty", $actval);
	}

	/**
	 *
	 * @depends testSettingsAddNew
	 */
	public function testSettingsSetInstantSave()
	{
		\Froxlor\Settings::Set('temp.setting', 'temp-value');
		\Froxlor\Settings::Stash();
		$tmpval = \Froxlor\Settings::Get('temp.setting');
		$this->assertEquals("temp-value", $tmpval);
	}

	/**
	 *
	 * @depends testSettingsAddNew
	 */
	public function testSettingsSetFlushSave()
	{
		\Froxlor\Settings::Set('temp.setting', 'another-temp-value', false);
		\Froxlor\Settings::Flush();
		$actval = \Froxlor\Settings::Get('temp.setting');
		$this->assertEquals("another-temp-value", $actval);
	}

	public function testSettingsIsInList()
	{
		$result = \Froxlor\Settings::IsInList("system.mysql_access_host", "localhost");
		$this->assertTrue($result);
		$result = \Froxlor\Settings::IsInList("system.mysql_access_host", "my-super-domain.de");
		$this->assertFalse($result);
	}
	
	public function testFroxlorVhostSettings()
	{
		// bootstrap.php adds two IPs, one ssl one non-ssl both with vhostcontainer = 1
		$result = \Froxlor\Settings\FroxlorVhostSettings::hasVhostContainerEnabled(false);
		$this->assertTrue($result);
		$result = \Froxlor\Settings\FroxlorVhostSettings::hasVhostContainerEnabled(true);
		$this->assertTrue($result);
		// now disable both
		\Froxlor\Database\Database::query("UPDATE `". TABLE_PANEL_IPSANDPORTS . "` SET `vhostcontainer` = '0'");
		$result = \Froxlor\Settings\FroxlorVhostSettings::hasVhostContainerEnabled(false);
		$this->assertFalse($result);
		$result = \Froxlor\Settings\FroxlorVhostSettings::hasVhostContainerEnabled(true);
		$this->assertFalse($result);
		// and change back
		\Froxlor\Database\Database::query("UPDATE `". TABLE_PANEL_IPSANDPORTS . "` SET `vhostcontainer` = '1'");
	}
}
