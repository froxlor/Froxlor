<?php
use PHPUnit\Framework\TestCase;
use Froxlor\Settings;
use Froxlor\Api\Commands\Customers;
use Froxlor\Database\Database;
use Froxlor\Settings\Store;

/**
 *
 * @covers \Froxlor\Settings\Store
 */
class StoreTest extends TestCase
{

	public function testStoreSettingClearCertificates()
	{
		// when froxlor vhost setting "use lets encrypt" is set to false, the corresponding
		// certificate needs to be cleaned
		// for testing purposes, let's add some entry to the table
		Database::query("INSERT INTO `domain_ssl_settings` SET `domainid` = '0', `ssl_cert_file` = 'test-content'");

		$fielddata = array(
			'label' => 'le_froxlor_enabled',
			'settinggroup' => 'system',
			'varname' => 'le_froxlor_enabled'
		);
		Store::storeSettingClearCertificates('system_le_froxlor_enabled', $fielddata, 0);

		// there should be no entry in domain_ssl_settings now
		$result = Database::query("SELECT COUNT(*) as entries FROM `domain_ssl_settings` WHERE `domainid` = '0'");
		$result = $result->fetch(\PDO::FETCH_ASSOC);
		$this->assertEquals(0, (int) $result['entries']);

		// truncate the table for other tests
		Database::query("TRUNCATE TABLE `" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "`;");
	}

	public function testStoreSettingDefaultIp()
	{
		global $admin_userdata;

		// the customer should have a std-subdomin
		Customers::getLocal($admin_userdata, array(
			'id' => 1,
			'createstdsubdomain' => 1
		))->update();
		
		// we need a second non-ssl IP
		Database::query("INSERT INTO `panel_ipsandports` SET `ip` = '82.149.225.47', `port` = '80'");
		$ip_id = Database::lastInsertId();
		$default_ip = Settings::Get('system.defaultip');

		// get all std-subdomains
		$customerstddomains_result_stmt = Database::prepare("
			SELECT `standardsubdomain` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `standardsubdomain` <> '0'
		");
		Database::pexecute($customerstddomains_result_stmt);

		$ids = array();
		while ($customerstddomains_row = $customerstddomains_result_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$ids[] = (int) $customerstddomains_row['standardsubdomain'];
		}
		
		if (count($ids) <= 0) {
			$this->fail("There should be customer std-subdomains for this test to make sense");
		}
		
		// check that they have the current default IP set
		$sel_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_DOMAINTOIP . "`
			WHERE `id_domain` IN (" . implode(', ', $ids) . ") AND `id_ipandports` = :ipid
		");
		Database::pexecute($sel_stmt, array('ipid' => $default_ip));
		$current_result = $sel_stmt->fetchAll(\PDO::FETCH_ASSOC);
		// we assume there are entries
		$this->assertTrue(count($current_result) > 0);

		$fielddata = array(
			'label' => 'serversettingsipaddress',
			'settinggroup' => 'system',
			'varname' => 'defaultip'
		);
		Store::storeSettingDefaultIp('serversettings_ipaddress', $fielddata, $ip_id);
		
		// check that they do not have the current default IP set anymore
		Database::pexecute($sel_stmt, array('ipid' => $default_ip));
		$current_result = $sel_stmt->fetchAll(\PDO::FETCH_ASSOC);
		// we assume there are entries
		$this->assertTrue(count($current_result) == 0);
		
		// check that they have the new default IP set
		Database::pexecute($sel_stmt, array('ipid' => $ip_id));
		$current_result = $sel_stmt->fetchAll(\PDO::FETCH_ASSOC);
		// we assume there are entries
		$this->assertTrue(count($current_result) > 0);
	}
	
	public function testStoreSettingDefaultTheme()
	{
		$current_theme = Settings::Get('panel.default_theme');
		// allow theme changing for admins/customers so a new default won't overwrite
		Settings::Set('panel.allow_theme_change_customer', 1);
		Settings::Set('panel.allow_theme_change_admin', 1);
		$fielddata = array(
			'label' => 'panel_default_theme',
			'settinggroup' => 'panel',
			'varname' => 'default_theme'
		);
		Store::storeSettingDefaultTheme('panel_default_theme', $fielddata, "newTheme");
		$this->assertTrue($current_theme != Settings::Get('panel.default_theme'));
		$this->assertEquals("newTheme", Settings::Get('panel.default_theme'));
		// validate admin/customer field did not change
		$sel_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_ADMINS . "`
			WHERE `theme` = :newtheme
		");
		Database::pexecute($sel_stmt, array('newtheme' => "newTheme"));
		$current_result = $sel_stmt->fetchAll(\PDO::FETCH_ASSOC);
		// we assume there are entries
		$this->assertTrue(count($current_result) == 0);
		$sel_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "`
			WHERE `theme` = :newtheme
		");
		Database::pexecute($sel_stmt, array('newtheme' => "newTheme"));
		$current_result = $sel_stmt->fetchAll(\PDO::FETCH_ASSOC);
		// we assume there are entries
		$this->assertTrue(count($current_result) == 0);
		// now do not allow changing of themes so the theme should get updated for all admins/customers
		// allow theme changing for admins/customers so a new default won't overwrite
		Settings::Set('panel.allow_theme_change_customer', 0);
		Settings::Set('panel.allow_theme_change_admin', 0);
		Store::storeSettingDefaultTheme('panel_default_theme', $fielddata, "newTheme");
		// validate admin/customer field did change
		$sel_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_ADMINS . "`
			WHERE `theme` = :newtheme
		");
		Database::pexecute($sel_stmt, array('newtheme' => "newTheme"));
		$current_result = $sel_stmt->fetchAll(\PDO::FETCH_ASSOC);
		// we assume there are entries
		$this->assertTrue(count($current_result) > 0);
		$sel_stmt = Database::prepare("
			SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "`
			WHERE `theme` = :newtheme
		");
		Database::pexecute($sel_stmt, array('newtheme' => "newTheme"));
		$current_result = $sel_stmt->fetchAll(\PDO::FETCH_ASSOC);
		// we assume there are entries
		$this->assertTrue(count($current_result) > 0);
		// set back to default
		Store::storeSettingDefaultTheme('panel_default_theme', $fielddata, $current_theme);
	}
}
