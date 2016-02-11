<?php

/**
 * Function to move a given customer to a given admin/reseller
 * and update all its references accordingly
 *
 * @param int $id customer-id
 * @param int $adminid target-admin-id
 *
 * @return true on success, error-message on failure
 */
function moveCustomerToAdmin($id = 0, $adminid = 0) {

    global $log;

	if ($id <= 0 || $adminid <= 0) {
		return "no valid id's given";
	}

	// get current admin-id
	$cAdmin_stmt = Database::prepare ( "
		SELECT `adminid` FROM `" . TABLE_PANEL_CUSTOMERS . "`
		WHERE `customerid` = :cid
	" );
	$cAdmin = Database::pexecute_first ( $cAdmin_stmt, array (
			'cid' => $id
	) );

	$log->logAction(ADM_ACTION, LOG_INFO, "moved user #" . $id . " from admin/reseller #".$cAdmin['adminid']." to admin/reseller #".$adminid);

	// Update customer entry
	$updCustomer_stmt = Database::prepare ( "
		UPDATE `" . TABLE_PANEL_CUSTOMERS . "` SET `adminid` = :adminid WHERE `customerid` = :cid
	" );
	Database::pexecute ( $updCustomer_stmt, array (
			'adminid' => $adminid,
			'cid' => $id
	) );

	// Update customer-domains
	$updDomains_stmt = Database::prepare ( "
		UPDATE `" . TABLE_PANEL_DOMAINS . "` SET `adminid` = :adminid WHERE `customerid` = :cid
	" );
	Database::pexecute ( $updDomains_stmt, array (
			'adminid' => $adminid,
			'cid' => $id
	) );

	// Update customer-tickets
	$updTickets_stmt = Database::prepare ( "
		UPDATE `" . TABLE_PANEL_TICKETS . "` SET `adminid` = :adminid WHERE `customerid` = :cid
	" );
	Database::pexecute ( $updTickets_stmt, array (
			'adminid' => $adminid,
			'cid' => $id
	) );

	// now, recalculate the resource-usage for the old and the new admin
	updateCounters ( false );

	return true;
}
