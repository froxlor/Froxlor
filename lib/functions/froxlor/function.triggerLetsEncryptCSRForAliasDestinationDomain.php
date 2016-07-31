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
 * @author     Daniel Reichelt <hacking@nachtgeist.net> (2016-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

function triggerLetsEncryptCSRForAliasDestinationDomain($aliasDestinationDomainID, $log)
{
	if (isset($aliasDestinationDomainID) && $aliasDestinationDomainID > 0) {
		$log->logAction(ADM_ACTION, LOG_INFO, "LetsEncrypt CSR triggered for domain ID " . $aliasDestinationDomainID);
		$upd_stmt = Database::prepare(
			"UPDATE
					`" . TABLE_PANEL_DOMAIN_SSL_SETTINGS . "`
				SET
					`expirationdate` = null
				WHERE
					domainid = :domainid
			");
		Database::pexecute($upd_stmt, array(
			'domainid' => $aliasDestinationDomainID
		));
	}
}
