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

//
// split_sql_file will split an uploaded sql file into single sql statements.
// Note: expects trim() to have already been run on $sql
// The whole function has been taken from the phpbb installer, copyright by the phpbb team, phpbb in summer 2004.
//

function split_sql_file($sql, $delimiter)
{
	// Split up our string into "possible" SQL statements.

	$tokens = explode($delimiter, $sql);

	// try to save mem.

	$sql = "";
	$output = array();

	// we don't actually care about the matches preg gives us.

	$matches = array();

	// this is faster than calling count($oktens) every time thru the loop.

	$token_count = count($tokens);
	for ($i = 0;$i < $token_count;$i++)
	{
		// Don't wanna add an empty string as the last thing in the array.

		if(($i != ($token_count - 1))
		   || (strlen($tokens[$i] > 0)))
		{
			// This is the total number of single quotes in the token.

			$total_quotes = preg_match_all("/'/", $tokens[$i], $matches);

			// Counts single quotes that are preceded by an odd number of backslashes,
			// which means they're escaped quotes.

			$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
			$unescaped_quotes = $total_quotes - $escaped_quotes;

			// If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.

			if(($unescaped_quotes % 2) == 0)
			{
				// It's a complete sql statement.

				$output[] = $tokens[$i];

				// save memory.

				$tokens[$i] = "";
			}
			else
			{
				// incomplete sql statement. keep adding tokens until we have a complete one.
				// $temp will hold what we have so far.

				$temp = $tokens[$i] . $delimiter;

				// save memory..

				$tokens[$i] = "";

				// Do we have a complete statement yet?

				$complete_stmt = false;
				for ($j = $i + 1;(!$complete_stmt && ($j < $token_count));$j++)
				{
					// This is the total number of single quotes in the token.

					$total_quotes = preg_match_all("/'/", $tokens[$j], $matches);

					// Counts single quotes that are preceded by an odd number of backslashes,
					// which means they're escaped quotes.

					$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
					$unescaped_quotes = $total_quotes - $escaped_quotes;

					if(($unescaped_quotes % 2) == 1)
					{
						// odd number of unescaped quotes. In combination with the previous incomplete
						// statement(s), we now have a complete statement. (2 odds always make an even)

						$output[] = $temp . $tokens[$j];

						// save memory.

						$tokens[$j] = "";
						$temp = "";

						// exit the loop.

						$complete_stmt = true;

						// make sure the outer loop continues at the right point.

						$i = $j;
					}
					else
					{
						// even number of unescaped quotes. We still don't have a complete statement.
						// (1 odd and 1 even always make an odd)

						$temp.= $tokens[$j] . $delimiter;

						// save memory.

						$tokens[$j] = "";
					}
				}

				// for..
			}

			// else
		}
	}

	return $output;
}
