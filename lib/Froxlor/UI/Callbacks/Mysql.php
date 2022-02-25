<?php

namespace Froxlor\UI\Callbacks;

use Froxlor\Database\Database;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Listing
 *
 */

class Mysql
{
	public static function dbserver(string $data, array $attributes): string
	{
		// get sql-root access data
		Database::needRoot(true, (int) $data);
		Database::needSqlData();
		$sql_root = Database::getSqlData();
		Database::needRoot(false);

		return $sql_root['caption'] . '<br><small>' . $sql_root['host'] . '</small>';
	}
}
