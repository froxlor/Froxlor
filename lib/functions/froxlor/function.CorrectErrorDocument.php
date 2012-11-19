<?php

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
 * @package    Functions
 *
 */

/*
 * this functions validates a given value as ErrorDocument
 * refs #267
 * 
 * @param string error-document-string
 * 
 * @return string error-document-string
 * 
 */
 function correctErrorDocument($errdoc = null)
 {
 	global $settings, $idna_convert, $theme;

 	if($errdoc !== null && $errdoc != '')
 	{
 		// not a URL
 		if((strtoupper(substr($errdoc, 0, 5)) != 'HTTP:' 
 			&& strtoupper(substr($errdoc, 0, 6)) != 'HTTPS:')
 			|| !validateUrl($idna_convert->encode($errdoc)))
 		{
 			// a file
 			if(substr($errdoc, 0, 1) != '"')
 			{
 				$errdoc = makeCorrectFile($errdoc);
 				// apache needs a starting-slash (starting at the domains-docroot)
 				if(!substr($errdoc, 0, 1) == '/') {
 					$errdoc = '/'.$errdoc;
 				}
 			}
 			// a string (check for ending ")
 			else
 			{
 				// string won't work for lighty
 				if($settings['system']['webserver'] == 'lighttpd')
 				{
 					standard_error('stringerrordocumentnotvalidforlighty');
 				}
 				elseif(substr($errdoc, -1) != '"')
 				{
 					$errdoc .= '"';
 				}
 			}
 		}
 		else
 		{
 		 	if($settings['system']['webserver'] == 'lighttpd')
 			{
 				standard_error('urlerrordocumentnotvalidforlighty');
 			}
 		}
 	}
 	return $errdoc;
 }
