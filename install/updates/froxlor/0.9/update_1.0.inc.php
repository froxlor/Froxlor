<?php

/*
if(isFroxlorVersion('0.9'))
{
	showUpdateStep("Updating from 0.9 to 1.0", false);
	showUpdateStep("Converting database tables to UTF-8");

	// Convert all data to UTF-8 to have a sane standard across all data
	$result = $db->query("SHOW TABLES");
	while($table = $db->fetch_array($result, 'num'))
	{
		$db->query("ALTER TABLE " . $table[0] . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
		$db->query("ALTER TABLE " . $table[0] . " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

		$affected_columns = array();

		$primarykey = "";
		$columns = $db->query("SHOW COLUMNS FROM ".$table[0]);
		while ($column = $db->fetch_array($columns))
		{
			if (!(strpos($column['Type'], "char") === false) || !(strpos($column['Type'], "text") === false))
			{
				$affected_columns[] = $column['Field'];
			}

			if ($column['Key'] == 'PRI') {
				$primarykey = $column['Field'];
			}
		}

		$count_cols = count($affected_columns);
		if ($count_cols > 0)
		{
			$load = "";
			foreach($affected_columns as $col)
			{
				$load .= ", `" . $col . "`";
			}

			$rows = $db->query("SELECT $primarykey" . $load . " FROM `" . $table[0] . "`");
			while ($row = $db->fetch_array($rows))
			{
				$changes = "";
				for ($i = 0; $i < $count_cols; $i++)
				{
					$base = "`" . $affected_columns[$i] . "` = '" . convertUtf8($row[$affected_columns[$i]]) . "'";
					$changes .= ($i == ($count_cols-1)) ? $base : $base . ", ";
				}

				$db->query("UPDATE `" . $table[0] . "` SET " . $changes . " WHERE `$primarykey` = '" . $db->escape($row[$primarykey]) . "';");
			}
		}
	}
	
	lastStepStatus(0);
}
*/

?>
