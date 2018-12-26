<?php
namespace Froxlor\Http;

use Froxlor\Database\Database;

class PhpConfig
{

	/**
	 * returns an array of existing php-configurations
	 * in our database for the settings-array
	 *
	 * @return array
	 */
	public static function getPhpConfigs()
	{
		$configs_array = array();

		// check if table exists because this is used in a preconfig
		// where the tables possibly does not exist yet
		$results = Database::query("SHOW TABLES LIKE '" . TABLE_PANEL_PHPCONFIGS . "'");
		if (! $results) {
			$configs_array[1] = 'Default php.ini';
		} else {
			// get all configs
			$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "`");
			while ($row = $result_stmt->fetch(\PDO::FETCH_ASSOC)) {
				if (! isset($configs_array[$row['id']]) && ! in_array($row['id'], $configs_array)) {
					$configs_array[$row['id']] = html_entity_decode($row['description']);
				}
			}
		}
		return $configs_array;
	}
}
