<?php

fwrite($debugHandler, "calculating mailspace usage\n");

$maildirs = $db->query("SELECT `id`, CONCAT(`homedir`, `maildir`) AS `maildirpath` FROM `".TABLE_MAIL_USERS."` ORDER BY `id`");

while ($maildir = $db->fetch_array($maildirs)) {

	$_maildir = makeCorrectDir($maildir['maildirpath']);

	if (file_exists($_maildir) 
		&& is_dir($_maildir)
	) {
		$back = safe_exec('du -sb ' . escapeshellarg($_maildir) . '');
		foreach ($back as $backrow) {
			$emailusage = explode(' ', $backrow);
		}
		$emailusage = floatval($emailusage['0']);
		unset($back);
		$db->query("UPDATE `".TABLE_MAIL_USERS."` SET `mboxsize` = '".(int)$emailusage."' WHERE `id` ='".(int)$maildir['id']."'");
	} else {
		fwrite($debugHandler, 'maildir ' . $_maildir . ' does not exist' . "\n");
	}
}
