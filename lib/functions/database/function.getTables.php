<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

/**
 * Returns an array with all tables with keys which are in the currently selected database
 *
 * @param  db    A valid DB-object
 * @return array Array with tables and keys
 *
 * @author Florian Lippert <flo@syscp.org>
 */

function getTables(&$db)
{
	// This variable is our return-value

	$tables = array();

	// The fieldname in the associative array which we get by fetch_array()

	$tablefieldname = 'Tables_in_' . $db->database;

	// Query for a list of tables in the currently selected database

	$tables_result = $db->query('SHOW TABLES');

	while($tables_row = $db->fetch_array($tables_result))
	{
		// Extract tablename

		$tablename = $tables_row[$tablefieldname];

		// Create sub-array with key tablename

		$tables[$tablename] = array();

		// Query for a list of indexes of the currently selected table

		$keys_result = $db->query('SHOW INDEX FROM ' . $tablename);

		while($keys_row = $db->fetch_array($keys_result))
		{
			// Extract keyname

			$keyname = $keys_row['Key_name'];

			// If there is aleady a key in our tablename-sub-array with has the same name as our key
			// OR if the sequence is not one
			// then we have more then index-columns for our keyname

			if((isset($tables[$tablename][$keyname]) && $tables[$tablename][$keyname] != '')
			   || $keys_row['Seq_in_index'] != '1')
			{
				// If there is no keyname in the tablename-sub-array set ...

				if(!isset($tables[$tablename][$keyname]))
				{
					// ... then create one

					$tables[$tablename][$keyname] = array();
				}

				// If the keyname-sub-array isn't an array ...

				elseif (!is_array($tables[$tablename][$keyname]))
				{
					// temporary move columname

					$tmpkeyvalue = $tables[$tablename][$keyname];

					// unset keyname-key

					unset($tables[$tablename][$keyname]);

					// create new array for keyname-key

					$tables[$tablename][$keyname] = array();

					// keyindex will be 1 by default, if seq is also 1 we'd better use 0 (this case shouldn't ever occur)

					$keyindex = ($keys_row['Seq_in_index'] == '1') ? '0' : '1';

					// then move back our tmp columname from above

					$tables[$tablename][$keyname][$keyindex] = $tmpkeyvalue;

					// end unset the variable afterwards

					unset($tmpkeyvalue);
				}

				// set columname

				$tables[$tablename][$keyname][$keys_row['Seq_in_index']] = $keys_row['Column_name'];
			}
			else
			{
				// set columname

				$tables[$tablename][$keyname] = $keys_row['Column_name'];
			}
		}
	}

	return $tables;
}
