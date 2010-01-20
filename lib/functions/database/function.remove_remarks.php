<?php

//
// remove_remarks will strip the sql comment lines out of an uploaded sql file
// The whole function has been taken from the phpbb installer, copyright by the phpbb team, phpbb in summer 2004.
//

function remove_remarks($sql)
{
	$lines = explode("\n", $sql);

	// try to keep mem. use down

	$sql = "";
	$linecount = count($lines);
	$output = "";
	for ($i = 0;$i < $linecount;$i++)
	{
		if(($i != ($linecount - 1))
		   || (strlen($lines[$i]) > 0))
		{
			if(substr($lines[$i], 0, 1) != "#")
			{
				$output.= $lines[$i] . "\n";
			}
			else
			{
				$output.= "\n";
			}

			// Trading a bit of speed for lower mem. use here.

			$lines[$i] = "";
		}
	}

	return $output;
}
