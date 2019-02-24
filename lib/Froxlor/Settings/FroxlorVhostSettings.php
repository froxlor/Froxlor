<?php
namespace Froxlor\Settings;

use Froxlor\Database\Database;

class FroxlorVhostSettings
{

	public static function hasVhostContainerEnabled($need_ssl = false)
	{
		$sel_stmt = Database::prepare("SELECT COUNT(*) as vcentries FROM `" . TABLE_PANEL_IPSANDPORTS . "` WHERE `vhostcontainer`= '1'" . ($need_ssl ? " AND `ssl` = '1'" : ""));
		$result = Database::pexecute_first($sel_stmt);
		return $result['vcentries'] > 0 ? true : false;
	}

}
